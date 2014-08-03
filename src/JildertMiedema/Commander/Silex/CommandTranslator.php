<?php
namespace JildertMiedema\Commander\Silex;

use JildertMiedema\Commander\CommandTranslatorInterface;

class CommandTranslator implements CommandTranslatorInterface
{
    public function toCommandHandler($command)
    {
        $class = get_class($command);
        $segments = explode('\\', $class);

        $segments = array_map(function($segment) {
            return lcfirst($segment);
        }, $segments);

        return implode('.', $segments) . '.handler';
    }

    public function toValidator($command)
    {
        $class = get_class($command);
        $segments = explode('\\', $class);

        $segments = array_map(function($segment) {
                return lcfirst($segment);
            }, $segments);

        return implode('.', $segments) . '.validator';
    }


} 