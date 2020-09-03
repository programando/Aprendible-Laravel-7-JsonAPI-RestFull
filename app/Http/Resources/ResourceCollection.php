<?php

namespace App\Http\Resources;

use App\Http\Resources\ObjectResource;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;

class ResourceCollection extends BaseResourceCollection
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
            'data' => ObjectResource::collection ( $this->collection),
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
