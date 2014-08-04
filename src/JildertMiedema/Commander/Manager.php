<?php
namespace JildertMiedema\Commander;

use JildertMiedema\Commander\Vanilla\CommandTranslator;
use JildertMiedema\Commander\Vanilla\Resolver;

class Manager
{
    private $mapper;
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     * @param Mapper $mapper
     */
    public function __construct(CommandBus $commandBus = null, Mapper $mapper = null)
    {
        $this->commandBus = $commandBus ? : $this->getDefaultCommandbus();
        $this->mapper = $mapper ? : new Mapper();
    }

    private function getDefaultCommandBus()
    {
        $translator = new CommandTranslator();
        $resolver =  new Resolver();
        $defaultCommandBus = new DefaultCommandBus($translator, $resolver);
        $commandBus = new ValidationCommandBus($defaultCommandBus, $translator, $resolver);

        return $commandBus;
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
