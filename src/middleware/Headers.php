<?php





$withHeader =  function ($request, $response, $next) {
   
    $response = $next($request, $response);
    return $response
         //   ->withAddedHeader('Content-Type','application/json; charset=utf-8')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization,DNT,X-CustomHeader,Keep-Alive,User-Agent,If-Modified-Since,Cache-Control')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
};




$app->add($withHeader);