<?php

namespace App\Models;

use PDO;
use Nette\Mail\Message;
use Nette\Mail\SmtpMailer as SmtpMailer;

/**
* 
*/
class Helper 
{
	private $connection;
	private $mailer;
	
	function __construct()
	{

	}

	/**
     * Static constructor / factory
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    /**
     *  Database connection
     */
    public function connectionDB($db) {
        
        return $this->connection = $db;

    }

    /**
     *  SMTP connection
     */
    public function connectionSMTP($email) {
        
        $this->mailer = $email;
        
    }

}