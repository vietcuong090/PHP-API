<?php

namespace App\Repositories\Issue;

use App\Http\Resources\IssuesResource;
use App\Repositories\EloquentRepository;
use App\Models\Issue;
use Illuminate\Support\Facades\Log;

class IssueEloquentRepository extends EloquentRepository implements IssueRepositoryInterface
{
    /**
     * get model
     *
     * @return string
     */
    public function getModel()
    {
        return Issue::class;
    }

    public function getAll()
    {
        return $this->_model->all();
    }

    public function findOrFail($id)
    {
        return $this->_model->findOrFail($id);
    }

    /**
     * get issues
     *
     * @param  array<string, string> $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator.
     */
    public function get($params, $lang)
    {
        // Define the common columns
        $commonColumns = [
            'id',
            'title',
            'user_id',
            'category_id',
            'status_id',
            'owner_id',
            'type_id',
            'parent_id',
            'created_at',
            'updated_at',
            'deleted_at'
        ];

        // Determine the content column based on language
        $contentColumn = $lang == 'vi' ? 'content_vi as content' : 'content';

        $queryColumn = array_merge($commonColumns, [$contentColumn]);
        // Initialize the query with eager loading relationships
        $query = $this->_model->with([
            'user:id,username',
            'category:id,name',
            'status:id,name',
            'owner:id,username',
            'type:id,name',
            'parent:id,title'
        ]);

        // Add the select columns
        $query->select($queryColumn);

        // Add where clauses based on $params
        foreach ($params as $key => $value) {
            $query->where($key, $value);
        }

        // Paginate the results
        $paginateData = $query->paginate(10);

        // Remove the unnecessary fields from the final result
        $paginateData->getCollection()->transform(function ($item) {
            // Remove the ids from the result
            unset($item->user_id);
            unset($item->category_id);
            unset($item->status_id);
            unset($item->owner_id);
            unset($item->type_id);
            unset($item->parent_id);
            return $item;
        });

        return $paginateData;
    }

    public function findBy($field, $values)
    {
        $model = $this->_model->where($field, $values)->get();
        return $model;
    }
}
