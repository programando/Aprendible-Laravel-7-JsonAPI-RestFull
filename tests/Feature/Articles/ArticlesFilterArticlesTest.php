<?php

namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use CloudCreativity\LaravelJsonApi\Testing\MakesJsonApiRequests;

class ArticlesFilterArticlesTest extends TestCase
{
     use RefreshDatabase;
    /**  @test       */
    public function can_filter_articles_by_title() {
         $articles = factory( Article::class)->create([
             'title' => 'Aprende laravel desde cero'
             ]);
         $articles = factory( Article::class)->create([
             'title' => 'Other title'
             ]);
        
        $urlName  = 'api.articles.index';
        $url = route ( $urlName, ['filter[title]'=>'Laravel']);
         
        $this->jsonApi()->get($url)->assertJsonCount(1,'data')
            ->assertSee('Aprende laravel desde cero')
            ->assertDontSee('Other title');

    }

    /**  @test       */
    public function can_filter_articles_by_content() {
         $articles = factory( Article::class)->create([
             'content' => '<div>Aprende laravel desde cero</div>'
             ]);
         $articles = factory( Article::class)->create([
             'content' => '<div>Other content</div>'
             ]);
        
        $urlName  = 'api.articles.index';
        $url = route ( $urlName, ['filter[content]'=>'Laravel']);
        $this->jsonApi()->get($url)
            ->assertJsonCount(1,'data')
            ->assertSee('Aprende laravel desde cero')
            ->assertDontSee('Other content');

    }



    /**  @test       */
    public function can_filter_articles_by_year() {
           factory( Article::class)->create([
             'title' => 'Article from 2020',
             'created_at' => now()->year(2020)
             ]);
           factory( Article::class)->create([
             'title' => 'Article from 2021',
             'created_at' => now()->year(2021)
             ]);

        $urlName  = 'api.articles.index';
        $url = route ( $urlName, ['filter[year]'=>2020]);
        $this->jsonApi()->get($url)
            ->assertJsonCount(1,'data')
            ->assertSee('Article from 2020')
            ->assertDontSee('Article from 2021');

    }


    /**  @test       */
    public function can_filter_articles_by_month() {

         factory( Article::class)->create([
             'title' => 'Article from Febrary 2020',
             'created_at' => now()->month(1)
             ]);
         factory( Article::class)->create([
             'title' => 'Another Article from Febrary 2020',
             'created_at' => now()->month(1)
             ]);             
         factory( Article::class)->create([
             'title' => 'Article from March 2021',
             'created_at' => now()->month(3)
             ]);

        $urlName  = 'api.articles.index';
        $url = route ( $urlName, ['filter[month]' => 1]);

        $this->jsonApi()->get($url)
            ->assertJsonCount(2,'data')
            ->assertSee('Article from Febrary 2020')
            ->assertSee('Another Article from Febrary 2020')
            ->assertDontSee('Article from March 2021');

    }


    /**  @test       */
      public function cannot_filter_articles_by_unknown_filters() {

         factory( Article::class)->create();

        $urlName  = 'api.articles.index';
        //$url = route ( $urlName, ['filter[unknown]' => 1]);
        $url = route('api.articles.index') . '?filter=unknown' ; 
       
        $this->jsonApi()->get($url)->assertStatus( 400 ) ; // Bad request
    }  


      /**  @test       */
    public function can_find_articles_by_title_and_content() {

         factory( Article::class)->create([
             'title' => 'Article from Aprendible 2020',
             'content' => 'Content'
             ]);
         factory( Article::class)->create([
             'title' => 'Another Article',
              'content' => 'Content Aprendible'
             ]);             
         factory( Article::class)->create([
             'title' => 'Article from March 2021',
              'content' => 'Content werewrewrw'
             ]);

        $urlName  = 'api.articles.index';
        $url = route ( $urlName, ['filter[search]' => 'Aprendible']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(2,'data')
            ->assertSee('Article from Aprendible 2020')
            ->assertSee('Another Article')
            ->assertDontSee('Article from March 2021');

    }


      /**  @test       */
    public function can_find_articles_by_title_and_content_with_multiple_term() {

         factory( Article::class)->create([
             'title' => 'Article from Aprendible 2020',
             'content' => 'Content'
             ]);
         factory( Article::class)->create([
             'title' => 'Another Article 1123',
              'content' => 'Content Laravel'
             ]);  
         factory( Article::class)->create([
             'title' => 'Another  Article',
              'content' => 'Content Aprendible'
             ]);              
         factory( Article::class)->create([
             'title' => 'Article from March 2021',
              'content' => 'Content werewrewrw'
             ]);

        $urlName  = 'api.articles.index';
        $url = route ( $urlName, ['filter[search]' => 'Aprendible Laravel']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(3,'data')
            ->assertSee('Article from Aprendible 2020')
            ->assertSee('Another Article 1123')
            ->assertSee('Another Article')
            ->assertDontSee('Article from March 2021');

    }
}
