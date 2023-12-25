<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"       => $this->id,
            "title"    => $this->title,
            "auther"   => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            "excerpt" => $this->excerpt,
            "content" => $this->content,
            "comments"   => $this->whenLoaded('approvedcomments', function () {
                return $this->approvedcomments;
           }),
            "created_at"    => $this->created_at,
        ];
    }
}
