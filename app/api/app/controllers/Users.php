<?php

namespace App\Controllers;

use PDO;
use Nette\Mail\Message;

//use App\Models\DbHandler;
/**
* 
*/

class Users 
{
    
    public function __construct(PDO $db) {
        $this->db = $db;
    }

	public function postRegister($request, $response)
	{
		try {				

			if ($this->isEmailValid($request, $response)) {

				$connection = $this->db;	

				$stmt = $connection->exec('INSERT INTO user(first_name, 
															last_name, 
															email, 
															password) 
												VALUES ("'.$request->getParsedBodyParam("first_name").'",
														"'.$request->getParsedBodyParam("last_name").'",
														"'.$request->getParsedBodyParam("email").'",
														"'.password_hash($request->getParsedBodyParam("password"), PASSWORD_DEFAULT).'")');
				$this->sendEmail($request);

				$data = array('status' => 201,'data' => 'ok', 'message' => 'Register successfully included.');
			}else{
				$data = array('status' => 401,'data' => 'error', 'message' => 'This email is already assossiated to another account.');
			}

			return $response->withHeader("Content-Type", "application/json")
				->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

		}catch(PDOException $e){
			echo "<br>" . $e->getMessage();
		}
	}

	public function isEmailValid($request, $response){
		
		try {
			$connection = $this->db;

			$emailValidate = $connection->prepare('SELECT COUNT(*) FROM user WHERE email = "'.$request->getParsedBodyParam("email").'"');
			$emailValidate->execute();
			$rows = $emailValidate->fetchColumn();
			
			return $rows == 0;

		}catch(PDOException $e){
			echo "<br>" . $e->getMessage();
			return false;
		}

	}

	public function sendEmail($request){
		$mail = new Message;

		$mail->setFrom('your@email.com')
				->addTo($request->getParam('email'))
				->setSubject('Plaease confirm your email')
				->setHTMLBody("Hello, to confirm this Email click this URL: <br />
				<a target='_blank' href='" . $this->container->settings['baseUrl'] . "auth/confirm?code=" . $activCode ."'>
				" . $this->container->settings['baseUrl'] . "/auth/confirm?code=" . $activCode . "</a>");
		 
		$this->mailer->send($mail);
		 
		//$this->flash->addMessage('info','Please confirm your email. We send a Email with activate Code.');
	}
}