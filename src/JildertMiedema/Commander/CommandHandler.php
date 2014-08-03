<?php
namespace JildertMiedema\Commander;

interface CommandHandler {

    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle($command);

}