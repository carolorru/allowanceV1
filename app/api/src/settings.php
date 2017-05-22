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
			'host' => getenv('DB_HOST'),
			'user' => getenv('DB_USER'),
			'pass' => getenv('DB_PASSWORD'),
			'dbname' => getenv('DB_NAME'),
		],

		// Send email
		'mailer' => [
			'host' => getenv('MAIL_HOST'),
			'username' => getenv('MAIL_USER'),
			'password' => getenv('MAIL_PASSWORD'),
		]
		
	],

	'baseUrl' => getenv('BASE_URL')
];
