<?php
namespace JildertMiedema\Commander\Silex;

use Silex\Application;
use JildertMiedema\Commander\CommandBus;
use JildertMiedema\Commander\DecoratedCommandBus;

class ValidationCommandBus implements CommandBus
{

    use DecoratedCommandBus;

    /**
     * @var CommandBus
     */
    protected $bus;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var CommandTranslator
     */
    protected $commandTranslator;

    function __construct(CommandBus $bus, Application $app, CommandTranslator $commandTranslator)
    {
        $this->bus = $bus;
        $this->app = $app;
        $this->commandTranslator = $commandTranslator;
    }

    /**
     * Execute a command with validation.
     *
     * @param $command
     * @return mixed
     */
    public function execute($command)
    {
        // If a validator is "registered," we will
        // first trigger it, before moving forward.
        $this->validateCommand($command);

        // Next, we'll execute any registered decorators.
        $this->executeDecorators($command);

        // And finally pass through to the handler class.
        return $this->bus->execute($command);
    }

    /**
     * If appropriate, validate command data.
     *
     * @param $command
     */
    protected function validateCommand($command)
    {
        $validator = $this->commandTranslator->toValidator($command);

        if (in_array($validator, $this->app->keys()))
        {
            $this->app[$validator]->validate($command);
        }
    }

}
