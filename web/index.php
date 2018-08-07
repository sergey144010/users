<?php

use sergey144010\users\Exception\NotFoundException;
use sergey144010\users\MapAction;
use sergey144010\users\Repository\UserRepository;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\ServiceManager\ServiceManager;

$appPath = dirname(dirname(__FILE__));
require $appPath . '/vendor/autoload.php';
$config = require $appPath . '/db/config.php';
if(is_file($appPath . '/db/config_local.php')){
    $config = require $appPath . '/db/config_local.php';
};

$serviceManager = new ServiceManager();
$serviceManager->addDelegator('logger', function ($container, $name, $callback) use ($appPath){
    $logger = new Logger;
    $writer = new Stream($appPath . '/log/log.txt');
    $logger->addWriter($writer);
    return $logger;
});
$serviceManager->addDelegator('twig', function ($container, $name, $callback) use ($appPath){
    $twigLoader = new FilesystemLoader([$appPath . '/templates']);
    $twig = new Environment($twigLoader);
    return $twig;
});
$serviceManager->addDelegator('repository', function ($container, $name, $callback) use ($config){
    try{
        $repository = new UserRepository($pdo = new \PDO($config['dsn'], $config['user'], $config['pass']));
    }catch (\PDOException $e){
        echo 'Check the connection settings for the database. File settings db/config.php. And create tables from db/create_tables.ini';
        exit;
    }
    return $repository;
});

$request = ServerRequestFactory::fromGlobals($_GET, $_POST);

$routerContainer = new Aura\Router\RouterContainer();
$map = $routerContainer->getMap();

(new MapAction($map))->withRequest($request)->init();

$matcher = $routerContainer->getMatcher();

$route = $matcher->match($request);
if (!$route) {
    throw new NotFoundException();
}

foreach ($route->attributes as $key => $val) {
    $request = $request->withAttribute($key, $val);
}

$callable = $route->handler;
$callable = is_string($callable) ? new $callable : $callable;
$response = $callable($request, $serviceManager);

(new SapiEmitter())->emit($response);