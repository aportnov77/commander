<?php
namespace JildertMiedema\Commander;


class Manager
{
    private $mapper;
    private $commandBus;

    /**
     * @param Mapper $mapper
     * @param CommandBus $commandBus
     */
    public function __construct(Mapper $mapper, CommandBus $commandBus)
    {
        $this->mapper = $mapper;
        $this->commandBus = $commandBus;
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