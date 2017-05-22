<?php


return [
	'settings' => [
		'displayErrorDetails' => true, // set to false in production
		'addContentLengthHeader' => false, // Allow the web server to send the content-length header

		// Renderer settings
		'renderer' => [
			'template_path' => __DIR__ . '/../templates/',
		],

		// Monolog settings
		'logger' => [
			'name' => 'slim-app',
			'path' => __DIR__ . '/../logs/app.log',
			'level' => \Monolog\Logger::DEBUG,
		],

		// DB settings
		'db' => [
			'host' => '127.0.0.1',
			'user' => 'root',
			'pass' => '',
			'dbname' => 'test',
		],

		// Send email
		'mailer' => [
			'host' => getenv('MAIL_HOST'),
			'username' => getenv('MAIL_USERNAME'),
			'password' => getenv('MAIL_PASSWORD'),
		]
		
	],

	'baseUrl' => getenv('BASE_URL')
];
