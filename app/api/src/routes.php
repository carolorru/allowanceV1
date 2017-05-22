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

  // CALL AN UNIQUE USER
	$app->get('/{id}',function($request, $response, $args){

		$this->logger->addInfo("Choose an user");
		$id = $name = $request->getAttribute('id');

		$connection = $this->db;
		$stmt = $connection->prepare('SELECT id, first_name, email FROM user WHERE id = '.$id.';');
		$stmt->execute();
		$rows = $stmt->fetchAll();


		$data = array('data' => $rows);

		return $response->withStatus(201)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	});

	$app->post('/add', 'Users:postRegister')->setName('user.register');

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
	$data["status"] = "ok";
	$data["token"] = $token;

	return $response->withStatus(201)
		->withHeader("Content-Type", "application/json")
		->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});



