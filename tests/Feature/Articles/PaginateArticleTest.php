<?php

namespace Tests\Feature;

use Tests\TestCase;
 
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaginateArticleTest extends TestCase
{
   // use RefreshDatabase;
    /**  @test       */
    public function cant_fetch_paginated_articles() 
    {
        $urlName  = 'api.articles.index';
        $articles = factory(Article::class)->times(10)->create();
        $url      = route( $urlName, ['page[size]'=>2, 'page[number]'=>3]);
        $response = $this->getJson( $url );
        $response->assertJsonCount(2,'data')                /// Ver dos elementos por pagina
            ->assertDontSee( $articles[0]->title)          //  En la pagina 3 no ver el primer elemento
            ->assertDontSee( $articles[1]->title)          
            ->assertDontSee( $articles[2]->title)          
            ->assertDontSee( $articles[3]->title)          
            ->assertSee     ( $articles[4]->title)          /// Si debo verlos en la segunda pagina     
            ->assertSee     ( $articles[5]->title)          
            ->assertDontSee( $articles[6]->title)          
            ->assertDontSee( $articles[8]->title)         
            ->assertDontSee( $articles[9]->title) ;       

        $response->assertJsonStructure ([
            'links' => ['first', 'last', 'prev','next']             /// Verificar que tengo estos datos para nevegación
        ])  ;

        

        $response->assertJsonFragment([
            'first' => route($urlName, ['page[size]'=>2, 'page[number]'=>1]),
            'last' => route($urlName, ['page[size]'=>2, 'page[number]'=>5]),
            'prev' => route($urlName, ['page[size]'=>2, 'page[number]'=>2]),
            'next' => route($urlName, ['page[size]'=>2, 'page[number]'=>4]),
        ]);


    }
}
