<?php
require_once '../vendor/autoload.php';

require_once 'silex/CommanderController.php';
require_once 'general/TestCommand.php';
require_once 'general/TestCommandHandler.php';
require_once 'general/TestCommandValidator.php';
require_once 'general/TestSantizer.php';

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new JildertMiedema\Commander\Silex\CommanderServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app['commander.controller'] = $app->share(function() use ($app) {
    return new CommanderController($app);
});

$app['testCommand.handler'] = $app->share(function() use ($app) {
    return new TestCommandHandler();
});

$app['commander.santizer'] = $app->share(function() use ($app) {
    return new TestSantizer();
});

$app['testCommand.validator'] = $app->share(function() use ($app) {
    return new TestCommandValidator();
});

$app->get('/', function() use ($app) {
    return $app['commander.executor']->execute('TestCommand');
});

$app->get('/santizer', function() use ($app) {
    return $app['commander.executor']->execute('TestCommand', null, ['commander.santizer']);
});

$app->get('/controller', 'commander.controller:test');

$app->run();
