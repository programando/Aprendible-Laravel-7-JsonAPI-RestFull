<?php

namespace App\Http\Resources;

use App\Http\Resources\ArticleResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => ArticleResource::collection ( $this->collection),
        ];
    }


    /*
                'links' => [
                'self' => route('api.articles.index')
            ],
            'meta' => [
                'articles_count' => $this->collection->count()
            ],
    */
}
