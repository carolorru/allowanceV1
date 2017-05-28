<?php

namespace App\Controllers;

use PDO;
use Nette\Mail\Message;
use Nette\Mail\SmtpMailer as SmtpMailer;

/**
* 
*/

class UserCtrl extends \App\Models\User
{
	private $activCode;
	private $user;

	public function __construct(PDO $db, SmtpMailer $email) 
	{
		parent::__construct($db);
		$this->mailer = $email;
	}

	public function setActiveCode($code)
	{
		$this->activCode = md5($code);
	}

	public function getActiveCode()
	{
		return $this->activCode;
	}

	public function isNewEmail($email)
	{
		$uniqueParam = ["email", $email];
		$this->user = parent::getUser($uniqueParam);
		return empty($this->user);
	}

	public function sendEmail($email, $activCode)
	{
		$mail = new Message;

		$mail->setFrom('Allowance App <contact@allowance.com.br>')
				->addTo($email)
				->setSubject('Plaease confirm your email')
				->setHTMLBody("NEW TEST SENDING EMAL <BR/><BR/><BR/><BR/>
				<a target='_blank' href='/auth/confirm?code=" . $activCode ."'>
				/auth/confirm?code=" . $activCode . "</a>");
		 
		$this->mailer->send($mail);	 
	}

	public function postRegister($request, $response)
	{
		if($this->isNewEmail($request->getParsedBodyParam("email"))){

			$this->setActiveCode($request->getParsedBodyParam("first_name") . date('Ymdhis'));

			$familyID = empty($request->getParsedBodyParam("family_id")) ? $request->getParsedBodyParam("family_id") : rand();
			$familyType = empty($request->getParsedBodyParam("family_type")) ? $request->getParsedBodyParam("family_type") : 1;

			parent::addUser($familyID, $familyType, $request->getParsedBodyParam("first_name"), $request->getParsedBodyParam("last_name"), $request->getParsedBodyParam("email"), $this->getActiveCode(), $request->getParsedBodyParam("password"));

			$this->sendEmail($request->getParsedBodyParam("email"), $this->getActiveCode());

			$data = array('status' => 201,'data' => 'ok', 'message' => 'Register successfully included. Check your email box to activate your account.');

		}else{
			$data = array('status' => 401,'data' => 'error', 'message' => 'This email is already assossiated to another account.');
		}

		return $response->withHeader("Content-Type", "application/json")
				->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));		
	}

	public function forgotPassword($request, $response)
	{
		if(!$this->isNewEmail($request->getParsedBodyParam("email"))){

			if($this->user['activ'] == 1){

				$this->setActiveCode($request->getParsedBodyParam("email") . date('Ymdhis'));

				$updateData = [["activ_code", $this->getActiveCode()]];
				$uniqueParam = ["email", $request->getParsedBodyParam("email")];
				parent::updateUser($updateData, $uniqueParam);

				$this->sendEmail($request->getParsedBodyParam("email"), $this->getActiveCode());

				$data = array('status' => 201,'data' => 'ok', 'message' => 'An email was send to you, so you can change your password.');
			}else{

				$data = array('status' => 401,'data' => 'ok', 'message' => 'This account is not active yet.');	
			}
		}else{

			$data = array('status' => 401,'data' => 'error', 'message' => 'This email is not assossiated to any account yet.');
		}
		
		return $response->withHeader("Content-Type", "application/json")
				->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}	

	public function confirmEmail($request, $response){
	 
		if (!$request->getParam('code')) {

			$data = array('status' => 401,'data' => 'error', 'message' => 'This is not an URL valid');			
		}else{

			$updateData = [["activ", 1], ["pass_tmp", " "]];
			$uniqueParam = ["activ_code", $request->getParam('code')];
			$this->user = parent::getUser($uniqueParam);

			parent::updateUser($updateData, $uniqueParam);

			$data = array('status' => 201, 'return' => $this->user, 'message' => 'Account activated.');
			
		}

	 	return $response->withHeader("Content-Type", "application/json")
				->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}

	public function changePassword($request, $response){
	 
		if (!$request->getParam('code')) {
			$data = array('status' => 401,'data' => 'error', 'message' => 'This is not an URL valid');
		}else{

			$updateData = [["password", password_hash($request->getParsedBodyParam("password"), PASSWORD_DEFAULT)]];
			$uniqueParam = ["activ_code", $request->getParam('code')];

			parent::updateUser($updateData, $uniqueParam);

			$data = array('status' => 201,'data' => 'ok', 'message' => 'Password changed successfully.');
		}
	 	
	 	return $response->withHeader("Content-Type", "application/json")
				->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));	 	
	}

}