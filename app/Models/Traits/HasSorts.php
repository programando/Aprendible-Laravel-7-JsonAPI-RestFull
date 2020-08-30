<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

 

trait HasSorts {

    public function scopeApplySorts( Builder $query, $sort ){
         
         if ( !property_exists ( $this, 'allowedSorts') )  abort(500,'Allowed property missing !. Add this property to :' . get_class($this)) ;
              
         if  (is_null($sort ))  return ;
        
         $sortFields   = Str::of( $sort )->explode(',') ;  // Campo por el que ordeno
         foreach ($sortFields as $sortField) {
           $direction = 'asc';                                  // Orden por defecto
            if ( Str::of( $sortField)->startsWith('-') ) {
                $direction ='desc';
                $sortField = Str::of ($sortField)->substr(1);       // Convierte a un objecto string y quita el primer caracter
            }

            // preguntamos si los campos de ordenamiento requeridos están permitidos.
            if ( !collect ( $this->allowedSorts)->contains($sortField  )) {
                abort(400,'Invalid sort field');
            }

            ///  Esta parte es el query builder de laravel. En este método es inyectado automáticamente
            //  y porteriormente puedo modificarlo.
            $query->orderby($sortField, $direction  );  
             
        }
         
    }

}