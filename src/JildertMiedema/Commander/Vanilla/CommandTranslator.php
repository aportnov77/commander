<?php
namespace JildertMiedema\Commander\Vanilla;

use JildertMiedema\Commander\CommandTranslatorInterface;

class CommandTranslator implements CommandTranslatorInterface
{

    public function toCommandHandler($command)
    {
        return get_class($command) . 'Handler';
    }

    public function toValidator($command)
    {
        return get_class($command) . 'Validator';
    }

}
