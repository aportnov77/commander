<?php
namespace JildertMiedema\Commander\Vanilla;

class CommandTranslatorTest extends \PHPUnit_Framework_TestCase {

    public function testToCommandHandler()
    {
        require_once __DIR__ . '/../helpers/TestCommand.php';
        require_once __DIR__ . '/../helpers/TestCommandHandler.php';
        $translator = new CommandTranslator();
        $objectName = $translator->toCommandHandler(new \TestCommand('', ''));

        $this->assertEquals('TestCommandHandler', $objectName);
    }

    public function testToValidator()
    {
        require_once __DIR__ . '/../helpers/TestCommand.php';
        require_once __DIR__ . '/../helpers/TestCommandValidator.php';
        $translator = new CommandTranslator();
        $objectName = $translator->toValidator(new \TestCommand('', ''));

        $this->assertEquals('TestCommandValidator', $objectName);
    }
}
