<?php

use JildertMiedema\Commander\CommandBus;

class TestSantizer implements CommandBus
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
        var_dump('santizer');

        foreach ($command as $key => $value) {
            $command->$key = trim($value);
        }
    }

} 
