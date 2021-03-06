<?php
use \Firebase\JWT\JWT;

// Routes

// USERS' GROUP
$app->group('/users',function() use ($app){

	$app->get('/',function ($request, $response, $args){
	
		$this->logger->addInfo("List users");

		$connection = $this->db;
		$stmt = $connection->prepare('SELECT id, first_name, email FROM user;');
		$stmt->execute();
		$rows = $stmt->fetchAll();

		$data = array('data' => $rows);

		return $response->withStatus(201)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	});

	$app->post('/add', 'UserCtrl:postRegister')->setName('user.register');

	$app->patch('/confirm','UserCtrl:confirmEmail')->setName('user.confirmEmail');

	$app->post('/forgotPassword','UserCtrl:forgotPassword')->setName('user.forgetPassword');

	$app->patch('/changePassword','UserCtrl:changePassword')->setName('user.changePassword');

  /*
  $app->put('/:id', function($id) use ($app){
	if($app->request->isPut())
	{
	  $db = connect_db();
	  
	  $sql = 'UPDATE user
			  SET first_name = "'.$app->request->post("first_name").'", 
				  last_name = "'.$app->request->post("last_name").'", 
				  email = "'.$app->request->post("email").'", 
				  password = "'.$app->request->post("password").'"
			  WHERE id = '.$id; 

	  if($db->query($sql) === TRUE) {
		  //$data = array('data'=>$app->request->post());
		  //$app->render('default.php',$data,200);
		return helpers::jsonResponse(false, 'data', $data );
	  } else {
		  echo "Error: " . $sql . "<br>" . $db->error;
	  }
	}
	else
	{
	  //$app->render(404);
	}
  });

  $app->delete('/:id', function($id) use ($app){
	if($app->request->isDelete())
	{
	  $db = connect_db();
	  
	  $sql = 'DELETE FROM user              
			  WHERE id = '.$id; 

	  if($db->query($sql) === TRUE) {
		  //$data = array('data'=>$app->request->post());
		  //$app->render('default.php',$data,200);
		return helpers::jsonResponse(false, 'data', $data );

	  } else {
		  echo "Error: " . $sql . "<br>" . $db->error;
	  }
	}
	else
	{
	  //$app->render(404);
	}
  });
*/
});















$app->get('/', function ($request, $response, $args) {
	// Sample log message
	$this->logger->info("Slim-Skeleton '/' route");

	// Render index view
	return $this->renderer->render($response, 'index.phtml', $args);
});

/*
$app->post("/token", function ($request, $response, $arguments) {

	$now = new DateTime();
	$future = new DateTime("now +2 hours");
	$server = $request->getServerParams();

	$payload = [
		"iat" => $now->getTimeStamp(),
		"exp" => $future->getTimeStamp(),
		"name" => $server["PHP_AUTH_USER"],
	];

	$secret = getenv('JWT_SECRET');
	$token = JWT::encode($payload, $secret, "HS256");

	$connection = $this->db;
	$stmt = $connection->prepare('SELECT id, first_name, last_name, email FROM user WHERE email = "'.$server["PHP_AUTH_USER"].'";');
	$stmt->execute();
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);

	$data["status"] = 201;
	$data["token"] = $token;
	$data["user"] = $rows;

	return $response->withStatus(201)
		->withHeader("Content-Type", "application/json")
		->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});

*/

$app->post('/token','Auth:authService')->setName('token.create');