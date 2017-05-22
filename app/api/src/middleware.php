<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
use \Slim\Middleware\HttpBasicAuthentication\PdoAuthenticator;

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    /*"users" => [
        "root" => "t00r",
        "somebody" => "passw0rd"
    ],*/
    "path" => "/token",
    "realm" => "Protected",
    "authenticator" => new PdoAuthenticator([
 
        "pdo" => $container["db"],
        "table" => "user",
        "user" => "first_name",
        "hash" => "password"
 
    ]),
    //"authenticator" => new PdoAuthenticatorCustom(),
    "callback" => function($request, $response, $arguments) {

        // echo "Through<br>\n";
        //print_r($arguments);

    },
    "error" => function($request, $response, $arguments) {

        //echo "Failed<br>\n";
        //print_r($arguments);
        return $response->write(json_encode($arguments, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

    }
]));

$app->add(new \Slim\Middleware\JwtAuthentication([
    "path" => ["/", "/admin"],
    "passthrough" => ["/token", "/users/add", "/users/confirm", "/users/forgotPassword", "/users/changePassword"],
    "secret" => getenv('JWT_SECRET'),
    "callback" => function ($request, $response, $arguments) use ($container) {

        $container["jwt"] = $arguments["decoded"];
        return $response->write(json_encode($container["jwt"]));

    },
    "error" => function ($request, $response, $arguments) use ($app) {

        $data = array();
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));

    }
]));

$app->add(new \Tuupola\Middleware\Cors([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["Authorization", "If-Match", "If-Unmodified-Since", "Content-Type", "Content-Range", "Content-Disposition", "Content-Description"]
]));
