<?php
namespace JildertMiedema\Commander;

use InvalidArgumentException;

trait DecoratedCommandBus 
{

    /**
     * List of optional decorators for command bus.
     *
     * @var array
     */
    protected $decorators = [];

    /**
     * Decorate the command bus with any executable actions.
     *
     * @param  string $className
     * @return mixed
     */
    public function decorate($className)
    {
        $this->decorators[] = $className;
    }

    /**
     * Execute all registered decorators
     *
     * @param  object $command
     * @return null
     */
    protected function executeDecorators($command)
    {
        foreach ($this->decorators as $decoratorName)
        {
            $instance = $this->resolver->resolve($decoratorName);

            if ( ! $instance instanceof CommandBus)
            {
                $message = 'The class to decorate must be an implementation of JildertMiedema\Commander\CommandBus';

                throw new InvalidArgumentException($message);
            }

            $instance->execute($command);
        }
    }
} 
