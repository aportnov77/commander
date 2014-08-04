<?php
namespace JildertMiedema\Commander\Silex;

use helpers\TestCommand;

class CommandTranslatorTest extends \PHPUnit_Framework_TestCase {

    public function testToCommandHandler()
    {
        require_once(__DIR__ . '/../helpers/TestCommand.php');
        $translator = new CommandTranslator();
        $handlerName = $translator->toCommandHandler(new TestCommand());
        $this->assertEquals('helpers.testCommand.handler', $handlerName);
    }

    public function testtoValidator()
    {
        require_once(__DIR__ . '/../helpers/TestCommand.php');
        $translator = new CommandTranslator();
        $validatorName = $translator->toValidator(new TestCommand());
        $this->assertEquals('helpers.testCommand.validator', $validatorName);
    }

}
