<?php
namespace JildertMiedema\Commander;

use Mockery as m;

class ValidationCommandBusTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var CommandTranslator
     */
    private $translator;

    /**
     * @var ValidationCommandBus
     */
    private $commandBus;


    /**
     * @var DefaultCommandBus
     */
    private $defaultCommandBus;


    protected function setUp()
    {
        parent::setUp();

        $this->resolver = m::mock('JildertMiedema\Commander\ResolverInterface');
        $this->translator = m::mock('JildertMiedema\Commander\CommandTranslatorInterface');
        $this->defaultCommandBus = m::mock('JildertMiedema\Commander\DefaultCommandBus');

        $this->commandBus = new ValidationCommandBus(
            $this->defaultCommandBus,
            $this->translator,
            $this->resolver
        );
    }

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testExecute()
    {
        $validator = m::mock('JildertMiedema\Commander\ValidationInterface');
        $this->resolver->shouldReceive('canResolve')->with('Validator')->andReturn(true);
        $this->resolver->shouldReceive('resolve')->with('Validator')->andReturn($validator);

        $this->translator->shouldReceive('toValidator')->once()->andReturn('Validator');
        $validator->shouldReceive('validate')->once()->andReturn(true);
        $this->defaultCommandBus->shouldReceive('execute')->once()->andReturn('Result');

        $command = m::mock('TestCommand');
        $result = $this->commandBus->execute($command);

        $this->assertEquals('Result', $result);
    }

    public function testExecuteWithDecorator()
    {
        $validator = m::mock('JildertMiedema\Commander\ValidationInterface');

        $decorator = m::mock('JildertMiedema\Commander\CommandBus');

        $this->resolver->shouldReceive('canResolve')->with('Validator')->andReturn(true);
        $this->resolver->shouldReceive('resolve')->with('Validator')->andReturn($validator);
        $this->resolver->shouldReceive('resolve')->with('Decorator')->andReturn($decorator);


        $this->translator->shouldReceive('toValidator')->once()->andReturn('Validator');
        $validator->shouldReceive('validate')->once()->andReturn(true);
        $this->defaultCommandBus->shouldReceive('execute')->once()->andReturn('Result');
        $decorator->shouldReceive('execute')->once();

        $this->commandBus->decorate('Decorator');

        $command = m::mock('TestCommand');
        $result = $this->commandBus->execute($command);

        $this->assertEquals('Result', $result);
    }
}
