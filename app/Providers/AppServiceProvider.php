<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Creación de una macro ( Elocuent builder)
        Builder::macro('jsonPaginate', function() {
                  return   $this->paginate( 
                        $perpage = request('page.size') ,
                        $columns = ['*'],
                        $pageName ='page[number]',
                        $page     = request('page.number')
                    )->appends( request()->except('page.number') ); /// Adiciona esta parte a la respuesta
        });
    }
}
