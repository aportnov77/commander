<?php

use JildertMiedema\Commander\CommandBus;

class TestSanitizer implements CommandBus
{
    /**
     * Execute a command
     *
     * @param $command
     *
     * @return mixed
     */
    public function execute($command)
    {
        var_dump('sanitizer');

        foreach ($command as $key => $value) {
            $command->$key = trim($value);
        }
    }

} 
