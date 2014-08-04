<?php

require_once '../vendor/autoload.php';

require_once 'general/TestCommand.php';
require_once 'general/TestCommandHandler.php';
require_once 'general/TestCommandValidator.php';
require_once 'general/TestSanitizer.php';

use JildertMiedema\Commander\Manager;
use JildertMiedema\Commander\Vanilla\Executor;

$manager = new Manager();
$executor = new Executor($manager);

echo $executor->execute('TestCommand', null, ['TestSanitizer']);
