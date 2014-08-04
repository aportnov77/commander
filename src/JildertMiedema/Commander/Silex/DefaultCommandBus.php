<?php
namespace JildertMiedema\Commander\Silex;

use Silex\Application;
use JildertMiedema\Commander\CommandBus;
use JildertMiedema\Commander\DecoratedCommandBus;

class DefaultCommandBus implements CommandBus {

    use DecoratedCommandBus;
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var CommandTranslator
     */
    protected $commandTranslator;

    /**
     * @param Application $app
     * @param CommandTranslator $commandTranslator
     */
    function __construct(Application $app, CommandTranslator $commandTranslator)
    {
        $this->app = $app;
        $this->commandTranslator = $commandTranslator;
    }

    /**
     * Execute the command
     *
     * @param $command
     * @return mixed
     */
    public function execute($command)
    {
        $this->executeDecorators($command);

        $handler = $this->commandTranslator->toCommandHandler($command);

        return $this->app[$handler]->handle($command);
    }
}
