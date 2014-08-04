<?php

use JildertMiedema\Commander\Silex\CommanderTrait;

class CommanderController
{
    use CommanderTrait;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     */
    public function __construct(Silex\Application $app)
    {
        $this->app = $app;
    }

    public function test()
    {
        return $this->execute('TestCommand', null, ['commander.sanitizer']);
    }
}
