<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
use Slim\App;
require  ('../vendor/autoload.php');




$environment = 'div';

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

/**
 * 
 * 
 */



/**
 * 
 * 
 */

require  ('../src/routes/RLogin.php');

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
