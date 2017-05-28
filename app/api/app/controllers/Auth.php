<?php

namespace App\Controllers;

use PDO;
use \Firebase\JWT\JWT;

/**
* 
*/
class Auth extends \App\Models\User
{
    private $token;
	
	function __construct(PDO $db)
	{
        $this->setToken();
        parent::__construct($db);
	}

	/**
     * Static constructor / factory
     */
    public function authService($request, $response) {
        $uniqueParam = ["email", $request->getServerParams()["PHP_AUTH_USER"]];
        
        $data["token"] = $this->getToken();
        $data["user"] = parent::getUser($uniqueParam);
        $data["family"] = parent::getFamily($data["user"]["family_id"]);

        return $response->withStatus(201)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }

    /**
     *  Set JWT token
     */
    public function setToken() {
        
        $now = new \DateTime();
        $future = new \DateTime("now +2 hours");

        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
        ];

        $secret = getenv('JWT_SECRET');
        $this->token = JWT::encode($payload, $secret, "HS256");

    }

    /**
     *  Get a new token
     */
    public function getToken() {
        
        return $this->token;

    }
    

}