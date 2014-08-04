<?php
namespace JildertMiedema\Commander;

class ValidationCommandBus implements CommandBus
{

    use DecoratedCommandBus;

    /**
     * @var CommandBus
     */
    protected $bus;

    /**
     * @var CommandTranslatorInterface
     */
    protected $commandTranslator;
    /**
     * @var ResolverInterface
     */
    private $resolver;

    /**
     * @param CommandBus $bus
     * @param CommandTranslatorInterface $commandTranslator
     * @param ResolverInterface $resolver
     */
    function __construct(
        CommandBus $bus,
        CommandTranslatorInterface $commandTranslator,
        ResolverInterface $resolver
    )
    {
        $this->bus = $bus;
        $this->commandTranslator = $commandTranslator;
        $this->resolver = $resolver;
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

        if ($this->resolver->canResolve($validator))
        {
            $this->resolver->resolve($validator)->validate($command);
        }
    }

}
