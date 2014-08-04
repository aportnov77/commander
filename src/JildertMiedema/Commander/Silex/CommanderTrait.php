<?php
namespace JildertMiedema\Commander\Silex;

use Silex\Application;

trait CommanderTrait 
{

    protected function execute($command, array $input = null, array $decorators = []) {
        if (!isset($this->app) || !($this->app instanceof Application)) {
            throw new \Exception(sprintf("Silex\Application needs to injected in '%s::\$app'", get_called_class()));
        }
        $input = $input ?: $this->app['request']->query->all();

        $manager = $this->app['commander.manager'];

        $command = $manager->getMapper()->mapInputToCommand($command, $input);

        $commandBus = $manager->getCommandBus();

        // If any decorators are passed, we'll
        // filter through and register them
        // with the CommandBus, so that they
        // are executed first.
        foreach ($decorators as $decorator)
        {
            $commandBus->decorate($decorator);
        }

        return $commandBus->execute($command);
    }

} 
