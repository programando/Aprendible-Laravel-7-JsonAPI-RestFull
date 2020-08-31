<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

class ArticleController extends Controller
{

    public function index() { 

        $articles =  Article::applyFilters()->applySorts()->jsonPaginate();
        return ArticleCollection::make ( $articles);
    }

    public function show( Article $article) {
        return ArticleResource::make($article );
    }



/*     public function index (){
        //return ArticleCollection::make (Article::all());   // Implementacion video 5
        $sortFields   = Str::of(request('sort'))->explode(',') ;  // Campo por el que ordeno
        $articleQuery = Article::query();
        foreach ($sortFields as $sortField) {
           $direction = 'asc';     // Orden por defecto
            if ( Str::of( $sortField)->startsWith('-') ) {
                $direction ='desc';
                $sortField = Str::of ($sortField)->substr(1);       // Convierte a un objecto string y quita el primer caracter
            }
            $articleQuery->orderby($sortField, $direction  );
        }
         
         if ( !isset($sortField) || $sortField=="" )
            return ArticleCollection::make (Article::all()); 

        //return ArticleCollection::make ( Article::orderBy( $sortField, $direction )->get() );
        
        return ArticleCollection::make ( $articleQuery->get() );

    } */






/*         return response()->json([
            'data' => Article::all()->map( function ( $article)  {
                return [
                    'type' => 'articles',
                    'id'    =>  (string)$article->getRouteKey(),
                    'attributes' => [
                        'title' => $article->title,
                        'slug'  => $article->slug,
                        'content' => $article->content,
                    ],
                    'links' => [
                        'self' => route('api.articles.show', $article),
                    ]
            ];
            })
        ]); */



}
