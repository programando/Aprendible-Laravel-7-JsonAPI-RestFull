<?php

namespace Tests\Feature;

use Tests\TestCase;
 
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortArticleTest extends TestCase
{
   //use RefreshDatabase;
    /**  @test       */
    public function it_can_sort_articles_by_title_asc()    {
        $this->withoutExceptionHandling();
        factory( Article::class)->create(['title' => 'C Title']);
        factory( Article::class)->create(['title' => 'A Title']);
        factory( Article::class)->create(['title' => 'B Title']);

        $url = route('api.articles.index',['sort' => 'title']);

        $this->getJson($url)->assertSeeInOrder ([
            'A Title',
            'B Title',
            'C Title'
        ]);
    }

    /**  @test       */
    public function it_can_sort_articles_by_title_desc()    {
        $this->withoutExceptionHandling();
        factory( Article::class)->create(['title' => 'C Title']);
        factory( Article::class)->create(['title' => 'A Title']);
        factory( Article::class)->create(['title' => 'B Title']);

        $url = route('api.articles.index',['sort' => '-title']);  // El menos (-) hace que el orden cambie a descendente

        $this->getJson($url)->assertSeeInOrder ([
            'C Title',
            'B Title',
            'A Title'
        ]);
    }



    /**  @test       */
    public function it_can_sort_articles_by_title_and_content()    {
        $this->withoutExceptionHandling();
        factory( Article::class)->create([
                'title' => 'C Title',
                'content' => 'F content' ]);
        factory( Article::class)->create([ 
                'title' => 'A Title',
                'content' => 'E content']);
        factory( Article::class)->create([ 
                'title' => 'B Title',
                'content' => 'X content']);

  /*       \DB::listen( function ($db ){
            dump( $db->sql);                            ///  Inspeccionar las consultas que genera laravel
        }); */
  
        $url = route('api.articles.index') . '?sort=title,-content' ;  

        $this->getJson($url)->assertSeeInOrder ([
            'A Title',
            'B Title',
            'C Title'
        ]);
   
 
         $url = route('api.articles.index') . '?sort=-content,title' ;  

        $this->getJson($url)->assertSeeInOrder ([
            'X content',
            'F content',
            'E content'
        ]);

 
    }

        /**  @test       */
    public function it_cannot_sort_articles_by_unknow_fields()    {
        factory( Article::class)->times(3)->create();
        $url = route('api.articles.index') . '?sort=unknown' ;  
        
        $this->getJson($url)->assertStatus(400);  /// Código de estado

    }




}
