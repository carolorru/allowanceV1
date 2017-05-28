<?php

namespace App\Models;

use PDO;
/**
* 
*/
class User extends Helper
{
	private $connection;

	function __construct(PDO $db)
	{
		
		$this->connection = parent::create()->connectionDB($db);
		
	}	

	public function addUser($familyID, $familyType, $fName, $lName, $email, $activCode, $password)
	{
		
		$stmt = $this->connection->exec('INSERT INTO user(first_name, 
													last_name, 
													email,
													activ_code,
													pass_tmp, 
													password,
													family_id,
													family_type) 
									VALUES ("'.$fName.'",
											"'.$lName.'",
											"'.$email.'",
											"'.$activCode.'",
											"'.$password.'",
											"'.password_hash($password, PASSWORD_DEFAULT).'",
											"'.$familyID.'",
											"'.$familyType.'")');
	}

	public function getUser($uniqueParam)
	{
		$sql = 'SELECT family_id,
					family_type,
					activ,
					activ_code,
					id, 
					first_name, 
					last_name, 
					email 
				FROM user';
		$sql .= ' WHERE ' . $uniqueParam[0] .' = "' . $uniqueParam[1] . '" LIMIT 1'; 
		
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		return $user;
	}

	public function deleteUser($id)
	{
		mysql_query("DELETE FROM users WHERE id=".$id);
	}

	public function updateUser($updateData, $uniqueParam)
	{
		$sql = 'UPDATE user SET ';
		foreach ($updateData as $v1) {
		    $sql .= $v1[0] . '="' . $v1[1] . '"'; 
		}
		$sql .= ' WHERE ' . $uniqueParam[0] .' = "' . $uniqueParam[1] . '"'; 

		$stmt = $this->connection->prepare($sql);
		$stmt->execute();		
	}

	public function getFamily($familyId)
	{
		$stmt = $this->connection->prepare('SELECT family_id,
											family_type,
											activ_code,
											id, 
											first_name, 
											last_name, 
											email 
										FROM user 
										WHERE family_id = "'.$familyId.'"');
		$stmt->execute();
		$family = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $family;
	}
}