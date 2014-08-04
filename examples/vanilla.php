<?php

require_once '../vendor/autoload.php';

require_once 'general/TestCommand.php';
require_once 'general/TestCommandHandler.php';
require_once 'general/TestCommandValidator.php';
require_once 'general/TestSantizer.php';

use JildertMiedema\Commander\Manager;
use JildertMiedema\Commander\Mapper;
use JildertMiedema\Commander\DefaultCommandBus;
use JildertMiedema\Commander\ValidationCommandBus;
use JildertMiedema\Commander\Vanilla\Executor;
use JildertMiedema\Commander\Vanilla\CommandTranslator;
use JildertMiedema\Commander\Vanilla\Resolver;

$translator = new CommandTranslator;
$resolver =  new Resolver;
$defaultCommandBus = new DefaultCommandBus($translator, $resolver);
$commandBus = new ValidationCommandBus($defaultCommandBus, $translator, $resolver);
$mapper = new Mapper();
$manager = new Manager($commandBus, $mapper);
$executor = new Executor($manager);

echo $executor->execute('TestCommand', null, ['TestSantizer']);
