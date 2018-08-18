<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
use Slim\App;
require  ('../vendor/autoload.php');




$environment = 'prod';

if($environment === 'div'){

    require  (__DIR__ .'/config/db/local.db.php');

    $conf=[
        'settings'=>[
            'displayErrorDetails'=>true,
        ],


    ];


} else{
    $conf=[
        'settings'=>[
            'displayErrorDetails'=>false,
        ],


    ];

    require  (__DIR__ .'/config/db/server.db.php');

}







$c   = new \Slim\Container($conf);
$app = new \Slim\App($c);



$container = $app->getContainer();
$container['db'] = new dbConnect();
$container['upload_directory'] =  $_SERVER['DOCUMENT_ROOT'] . '/uploads';






$withHeader =  function ($request, $response, $next) {

    $response = $next($request, $response);
    return $response
        ->withAddedHeader('Content-Type','application/json; charset=utf-8')
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Credentials', 'true')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization,DNT,X-CustomHeader,Keep-Alive,User-Agent,If-Modified-Since,Cache-Control')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
};




$app->add($withHeader);









/**
 * 
 * 
 */



/**
 * 
 * 
 */



require  ('../src/routes/RUsers.php');




require  ('../src/routes/REmployee.php');

require  ('../src/routes/RTasks.php');

require  ('../src/routes/RStandard.php');

require  ('../src/routes/REvaluationResults.php');






/**
 * 
 * 
 */

require  ('../src/middleware/auth.php');

require  ('../src/middleware/Headers.php');

require  ('../src/routes/RLogin.php');