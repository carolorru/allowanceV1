<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['db'] = function ($c) {
    
    $db = $c['settings']['db'];
    $pdo = null;

    try {

        $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['user'], $db['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    }catch(PDOException $e){
        echo "<br>" . $e->getMessage();
        return false;
    }
    return $pdo;
};

$container["jwt"] = function ($c) {
    return new StdClass;
};

$container['mailer'] = function($c) {
    return new Nette\Mail\SmtpMailer($c['settings']['mailer']);
};

//Controllers
$container['UserCtrl'] = function($c){
    return new \App\Controllers\UserCtrl($c->get('db'), $c->get('mailer'));
};

$container['Auth'] = function($c){
    return new \App\Controllers\Auth($c->get('db'));
};