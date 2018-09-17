<?php





$withHeader =  function ($request, $response, $next) {

    $Audience_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 
    $response = $next($request, $response);
    return $response
         //   ->withAddedHeader('Content-Type','application/json; charset=utf-8')
            ->withHeader('Access-Control-Allow-Origin',$Audience_link)
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization,DNT,X-CustomHeader,Keep-Alive,User-Agent,If-Modified-Since,Cache-Control')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
};




$app->add($withHeader);