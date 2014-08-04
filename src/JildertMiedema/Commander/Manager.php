<?php
namespace JildertMiedema\Commander;

class Manager
{
    private $mapper;
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     * @param Mapper $mapper
     */
    public function __construct(CommandBus $commandBus, Mapper $mapper)
    {
        $this->commandBus = $commandBus;
        $this->mapper = $mapper;
    }

    /**
     * @return ExecutorInterface
     */
    public function getExecutor()
    {
        return $this->executor;
    }

    /**
     * @return mixed
     */
    public function getCommandBus()
    {
        return $this->commandBus;
    }

    public function getMapper()
    {
        return $this->mapper;
    }
}
