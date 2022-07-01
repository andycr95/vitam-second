<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
  public function handle($request, Closure $next)
  {
    return $next($request)
       //Url a la que se le dará acceso en las peticiones
      ->header("Access-Control-Allow-Origin", "*")
      //Métodos que a los que se da acceso
      ->header("Access-Control-Allow-Methods", "PUT, POST, GET, OPTIONS, DELETE")
      ->header("Access-Control-Allow-Credentials", "true")
      ->header("Access-Control-Max-Age", "1000")
      //Headers de la petición
      ->header("Access-Control-Allow-Headers", "X-Requested-With", "Content-Type", "Origin", "Cache-Control", "Pragma", "Authorization", "Accept", "Accept-Encoding");
  }

}
