<?php

namespace App\Providers;

use App\Mixins\JsonApiBuilder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class ApiJsonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Creao un mixin para agupar funcionalidades, en este caso del laravel builder. Extiende las funcionalidades del builder
        //JsonApiBuilder  Es una classe creada en cualquier sitio de nuestra aplicación. Para el caso, App\Mixins. y allí creo la clase.
        Builder::mixin( new JsonApiBuilder); 
    }
}
