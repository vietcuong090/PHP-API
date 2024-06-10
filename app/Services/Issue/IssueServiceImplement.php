<?php

namespace App\Services\Issue;

use App\Helpers\ResponseTraits;
use App\Models\Category;
use App\Models\Issue;
use App\Models\Status;
use App\Models\Type;
use App\Models\User;
use App\Repositories\Issue\IssueRepositoryInterface;
use App\Services\MainService;
use Brick\Math\BigInteger;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class IssueServiceImplement extends MainService implements IssueServiceInterface
{
    use ResponseTraits;

    /**
     * get model
     *
     * @return string
     */
    public function getRepository()
    {
        return IssueRepositoryInterface::class;
    }

    public function index($params = [])
    {
        $validParams = array_intersect_key(
            $params,
            array_flip(
                [
                    'user_id',
                    'category_id',
                    'status_id',
                    'owner_id',
                    'type_id',
                    'parent_id'
                ]
            )
        );

        $query = Issue::query()->with(['user', 'category', 'status', 'owner', 'type', 'parent']);

        foreach ($validParams as $key => $value) {
            $query->where($key, $value);
        }

        $perPage = $params['per_page'] ?? 10;
        $page = $params['page'] ?? 1;

        $issues = $query->paginate($perPage, ['*'], 'page', $page);

        if ($issues->isEmpty()) {
            return $this->notFound('No records found.');
        }

        return $this->success($issues);
    }


    public function validateRequest(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string',
                'content' => 'required|string',
                'content_vi' => 'required|string',
                'user_id' => 'required|integer',
                'category_id' => 'required|integer',
                'status_id' => 'required|integer',
                'type_id' => 'required|integer',
            ]
        );
    }
    public function validateUser(int $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            $message = "User not found";
            return $this->notFound($message);
        }

        if ($user->roles()->where('name', 'admin')->exists()) {
            $message = "User is not valid";
            return $this->error($message);
        }

        return true;
    }
    private function validateModelExists(Request $request, $field)
    {
        $model = null;
        switch ($field) {
            case 'user_id':
                $model = User::find($request->user_id);
                break;
            case 'category_id':
                $model = Category::find($request->category_id);
                break;
            case 'status_id':
                $model = Status::find($request->status_id);
                break;
            case 'type_id':
                $model = Type::find($request->type_id);
                break;
        }
        return $model !== null;
    }

    private function validateModels(Request $request)
    {

        $validationMessages = [
            'user_id' => 'User not found',
            'category_id' => 'Category not found',
            'status_id' => 'Status not found',
            'type_id' => 'Type not found',
        ];

        foreach ($validationMessages as $field => $message) {
            if (!$this->validateModelExists($request, $field)) {
                return $this->notFound($message);
            }
        }

        $parent = Issue::find($request->parent_id);
        if ($parent && $parent->type_id != 1) {
            return $this->error("Parent's Id is not valid");
        }

        return null;
    }

    public function createForAdmin(Request $request)
    {
        try {
            $this->validateRequest($request);
        } catch (ValidationException $e) {
            return $this->error("Invalid data.");
        }

        if ($error = $this->validateModels($request)) {
            return $error;
        }

        $issueData = $request->all();
        $issueData['owner_id'] = Auth::user()->id;
        $issue = Issue::create($issueData);
        return $this->success($issue);
    }

    public function showForAdmin(string $id)
    {
        $issue = Issue::find($id);

        if (!$issue) {
            return $this->notFound();
        }
        return $this->success($issue);
    }

    public function updateForAdmin(Request $request, string $id)
    {
        $issue = Issue::find($id);

        if (!$issue) {
            return $this->notFound();
        }

        try {
            $this->validateRequest($request);
        } catch (ValidationException $e) {
            return $this->error("Invalid data.");
        }

        if ($error = $this->validateModels($request)) {
            return $error;
        }

        $issueData = $request->all();
        $issue->update($issueData);

        return $this->success($issue);
    }

    public function deleteForAdmin(string $id)
    {
        $issue = Issue::find($id);

        if (!$issue) {
            return $this->notFound();
        }

        $childIssues = Issue::where('parent_id', $issue->id)->get();

        foreach ($childIssues as $childIssue) {
            $childIssue->delete();
        }

        $issue->delete();

        return $this->success();
    }

    /**
     * Create new post
     *
     * @param  array<string, string> $data
     * @return mixed
     */
    public function createForUser(array $data)
    {
        $user = auth()->user();
        if (!$user) {
            return $this->notAuthorize();
        } else {
            $data['owner_id'] = $user->id;
        }

        if ($data['parent_id']) {
            $parentFunction = $this->_repository->find($data['parent_id']);

            if (!$parentFunction || $parentFunction->type->name !== 'function') {
                return $this->error('Invalid parent_id');
            }

            if ($data['type_id'] == Type::where('name', '=', 'function')) {
                return $this->error('Invalid type_id');
            }
        }

        $issue = $this->_repository->create($data);

        if (!$issue) {
            return $this->error($issue->toArray());
        }
        return $this->success($issue->toArray());
    }

    /**
     * @param  array<string, string> $data
     * @return mixed
     */
    public function updateForUser($id, array $data)
    {
        $issue =  $this->_repository->find($id);
        if (!$issue) {
            return $this->notFound();
        }
        $user =  auth()->user() ?? null;

        if (!$user || ($issue->owner_id != $user->id)) {
            return $this->forbidden();
        }

        if ($data['parent_id']) {
            $parentFunction = $this->_repository->find($data['parent_id']);

            if (!$parentFunction || $parentFunction->type->name !== 'function' || $parentFunction->id == $id) {
                return $this->error('Invalid parent_id');
            }

            if ($data['type_id'] == Type::where('name', '=', 'function')) {
                return $this->error('Invalid type_id');
            }
        }

        $isUpdated = $this->_repository->update($id, $data);
        if (!$isUpdated) {
            return $this->error('Something went wrong');
        }
        return $this->success($issue->id);
    }

    /**
     * Get all issues or by author with pagination
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator<\App\Models\Issue>
     */
    public function get($params = [], $lang = 'en')
    {
        $data = $this->_repository->get($params, $lang);
        return $this->success($data);
    }


    /**
     * Get issue by id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        $issue =  $this->_repository->find($id);
        if (!$issue) {
            return $this->notFound();
        }
        return $this->success($issue);
    }

    /**
     * Get issue by id
     *
     * @return mixed
     */
    public function getByIdAndLang(int $id, string $lang)
    {
        $issue =  $this->_repository->find($id);
        if (!$issue) {
            return $this->notFound();
        }
        if ($lang == 'en') {
            unset($issue->content_vi);
        } else {
            $issue->content = $issue->content_vi;
            unset($issue->content_vi);
        }
        return $this->success($issue);
    }

    /**
     * Delete issue by id
     *
     * @return mixed
     */
    public function deleteForUser($id)
    {
        $issue =  $this->_repository->find($id);
        if (!$issue) {
            return $this->notFound();
        }
        $user = auth()->user() ?? null;
        if (!$user || $issue->owner_id != $user->id) {
            return $this->forbidden();
        }

        // Recursively delete child issues
        $this->deleteChildren($issue->id);

        $isDeleted = $this->_repository->delete($id);

        if (!$isDeleted) {
            return $this->error('Something went wrong');
        }
        return $this->success($issue->id);
    }

    private function deleteChildren($parentId)
    {
        $children = $this->_repository->findBy('parent_id', $parentId);

        if ($children) {
            foreach ($children as $child) {
                $this->_repository->delete($child->id);
            }
        }
    }
}
