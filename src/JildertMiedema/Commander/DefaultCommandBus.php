<?php
namespace JildertMiedema\Commander;

class DefaultCommandBus implements CommandBus {

    use DecoratedCommandBus;

    /**
     * @var CommandTranslatorInterface
     */
    protected $commandTranslator;
    /**
     * @var ResolverInterface
     */
    private $resolver;

    /**
     * @param CommandTranslatorInterface $commandTranslator
     * @param ResolverInterface $resolver
     */
    function __construct(
        CommandTranslatorInterface $commandTranslator,
        ResolverInterface $resolver
    )
    {
        $this->commandTranslator = $commandTranslator;
        $this->resolver = $resolver;
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

        $handlerName = $this->commandTranslator->toCommandHandler($command);

        $handle = $this->resolver->resolve($handlerName);

        return $handle->handle($command);
    }
}
