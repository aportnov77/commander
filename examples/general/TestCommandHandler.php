<?php
use JildertMiedema\Commander\CommandHandler;

class TestCommandHandler implements CommandHandler
{

    public function handle($command)
    {
        var_dump('handle ', $command);

        return 'Succes';
    }

}
