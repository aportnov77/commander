<?php
namespace JildertMiedema\Commander\Vanilla;

use JildertMiedema\Commander\ExecutorInterface;
use JildertMiedema\Commander\Manager;

class Executor implements ExecutorInterface
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function execute($command, array $input = null, array $decorators = [])
    {
        $input = $input ?: ($_POST ?: $_GET);

        $manager = $this->manager;

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
