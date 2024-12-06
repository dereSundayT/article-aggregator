<?php

namespace App\Http\Resources;

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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'keywords' => $this->keywords,
            'image_url' => $this->image_url,
            'published_at' => $this->published_at,
            'source_id' => $this->source_id,
            'category_id' => $this->category_id,
            'author_id' => $this->author_id,
            'created_at' => $this->created_at,
            'source' => [
                'id' => $this->source->id,
                'name' => $this->source->name,
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
            ],
        ];
    }
}



