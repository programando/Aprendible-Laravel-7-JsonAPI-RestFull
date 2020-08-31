<?php

namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $this->getJson($url)
            ->assertJsonCount(1,'data')
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
        $this->getJson($url)
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
        $this->getJson($url)
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

        $this->getJson($url)
            ->assertJsonCount(2,'data')
            ->assertSee('Article from Febrary 2020')
            ->assertSee('Another Article from Febrary 2020')
            ->assertDontSee('Article from March 2021');

    }


}
