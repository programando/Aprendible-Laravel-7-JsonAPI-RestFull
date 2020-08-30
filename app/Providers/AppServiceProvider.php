<?php

namespace App\Providers;

 
use Illuminate\Support\Str;
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

        // $this->model hace referencia al modelo que esté usando la macro.
        // Nota:  Siempre se debe retornar el builer..... return $this;
        Builder::macro('applySorts', function(){

          if ( !property_exists ( $this->model, 'allowedSorts') )  {
              abort(500,'Allowed property missing !. Add this property to :' . get_class($this->model)) ;
          }

         if  (is_null($sort = request('sort')  ))  return $this;
        
         $sortFields   = Str::of( $sort )->explode(',') ;  // Campo por el que ordeno
         foreach ($sortFields as $sortField) {
            $direction = 'asc';                                  // Orden por defecto
                if ( Str::of( $sortField)->startsWith('-') ) {
                    $direction ='desc';
                    $sortField = Str::of ($sortField)->substr(1);       // Convierte a un objecto string y quita el primer caracter
                }

                // preguntamos si los campos de ordenamiento requeridos están permitidos.
                if ( !collect ( $this->model->allowedSorts)->contains($sortField  )) {
                    abort(400,'Invalid sort field');
                }

                ///  Esta parte es el query builder de laravel. En este método es inyectado automáticamente
                //  y porteriormente puedo modificarlo.
                $this->orderby($sortField, $direction  );            
            }
            return $this;
        });

    }
}
