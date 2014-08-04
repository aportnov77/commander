<?php
namespace JildertMiedema\Commander;

use Mockery as m;

class DefaultCommandBusTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var CommandTranslator
     */
    private $translator;

    /**
     * @var DefaultCommandBus
     */
    private $commandBus;

    /**
     * @var ResolverInterface
     */
    private $resolver;

    protected function setUp()
    {
        parent::setUp();

        $this->resolver = m::mock('JildertMiedema\Commander\ResolverInterface');
        $this->translator = m::mock('JildertMiedema\Commander\CommandTranslatorInterface');

        $this->commandBus = new DefaultCommandBus($this->translator, $this->resolver);
    }

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testExecute()
    {
        $handler = m::mock('JildertMiedema\Commander\CommandHandler');

        $this->translator->shouldReceive('toCommandHandler')->once()->andReturn('TestHandler');
        $this->resolver->shouldReceive('resolve')->with('TestHandler')->andReturn($handler);
        $handler->shouldReceive('handle')->once()->andReturn('Result');

        $command = m::mock('TestCommand');
        $result = $this->commandBus->execute($command);

        $this->assertEquals('Result', $result);
    }

    public function testExecuteWithDecorator()
    {
        $handler = m::mock('JildertMiedema\Commander\CommandHandler');
        $decorator = m::mock('JildertMiedema\Commander\CommandBus');

        $this->resolver->shouldReceive('resolve')->with('TestHandler')->andReturn($handler);
        $this->resolver->shouldReceive('resolve')->with('Decorator')->andReturn($decorator);

        $this->translator->shouldReceive('toCommandHandler')->once()->andReturn('TestHandler');
        $handler->shouldReceive('handle')->once()->andReturn('Result');
        $decorator->shouldReceive('execute')->once();

        $this->commandBus->decorate('Decorator');

        $command = m::mock('TestCommand');
        $result = $this->commandBus->execute($command);

        $this->assertEquals('Result', $result);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExecuteWithIncorrectDecorator()
    {
        $handler = m::mock('JildertMiedema\Commander\CommandHandler');
        $this->resolver->shouldReceive('resolve')->with('TestHandler')->andReturn($handler);

        $decorator = m::mock('StdClass');
        $this->resolver->shouldReceive('resolve')->with('Decorator')->andReturn($decorator);

        $this->commandBus->decorate('Decorator');

        $command = m::mock('TestCommand');
        $this->commandBus->execute($command);
    }
}
