<?php
namespace JildertMiedema\Commander\Silex;

use JildertMiedema\Commander\CommandTranslatorInterface;
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
     * @var CommandTranslatorInterface
     */
    protected $commandTranslator;

    /**
     * @param Application $app
     * @param CommandTranslatorInterface $commandTranslator
     */
    function __construct(Application $app, CommandTranslatorInterface $commandTranslator)
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
