<?php
require_once '../vendor/autoload.php';

require_once 'silex/CommanderController.php';
require_once 'general/TestCommand.php';
require_once 'general/TestCommandHandler.php';
require_once 'general/TestCommandValidator.php';
require_once 'general/TestSanitizer.php';

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

$app['commander.sanitizer'] = $app->share(function() use ($app) {
    return new TestSanitizer();
});

$app['testCommand.validator'] = $app->share(function() use ($app) {
    return new TestCommandValidator();
});

$app->get('/', function() use ($app) {
    return $app['commander.executor']->execute('TestCommand');
});

$app->get('/sanitizer', function() use ($app) {
    return $app['commander.executor']->execute('TestCommand', null, ['commander.sanitizer']);
});

$app->get('/controller', 'commander.controller:test');

$app->run();
