<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IssueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            // [
            //     'id' => $this->item->id,
            //     'title' => $this->id,
            //     'user' => $this->user,
            //     'category' => $this->category,
            //     'status' => $this->status,
            //     'owner' => $this->owner,
            //     'type' => $this->type,
            //     'parent' => $this->parent,
            //     'created_at' => $this->created_at,
            //     'updated_at' => $this->updated_at,
            //     'deleted_at' => $this->deleted_at,
            //     'content' => $this->content,
            // ],
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
