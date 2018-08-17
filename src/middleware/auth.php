<?php
use Firebase\JWT\JWT;

//  $headerValueString = $request->getHeaderLine('Authorization');
//
//
// $jwt= JWT::encode ($payload,$key);
// $jwt= JWT::decode ($headerValueString,$_ENV["tokenapi"]);
//



$app->add(new \Slim\Middleware\JwtAuthentication([
    "secure" => false,
    "path" => ["/api/v1"],
    "passthrough" => ["/api/v1/login", "/admin/ping"],
    "secret" => $_ENV["tokenapi"],

    "error" => function ($request, $response, $arguments) {
        $data["status"] = "error";
        $data["code"] = 401;
        $data["Header"] =$request->getHeaderLine('Authorization');
        $data["message"] = $arguments["message"]  ;
        return $response->withJson($data);
    }

]));





