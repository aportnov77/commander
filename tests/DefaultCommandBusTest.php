<?php
namespace JildertMiedema\Commander\Silex;

use Mockery as m;

class DefaultCommandBusTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Silex\Application
     */
    private $app;

    /**
     * @var CommandTranslator
     */
    private $translator;

    /**
     * @var DefaultCommandBus
     */
    private $commandBus;


    protected function setUp()
    {
        parent::setUp();

        $this->app = new \Silex\Application();
        $this->translator = m::mock('JildertMiedema\Commander\Silex\CommandTranslator');

        $this->commandBus = new DefaultCommandBus($this->app, $this->translator);
    }

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testExecute()
    {
        $handler = m::mock('JildertMiedema\Commander\CommandHandler');
        $this->app['TestHandler'] = $handler;

        $this->translator->shouldReceive('toCommandHandler')->once()->andReturn('TestHandler');
        $handler->shouldReceive('handle')->once()->andReturn('Result');

        $command = m::mock('TestCommand');
        $result = $this->commandBus->execute($command);

        $this->assertEquals('Result', $result);
    }

    public function testExecuteWithDecorator()
    {
        $handler = m::mock('JildertMiedema\Commander\CommandHandler');
        $this->app['TestHandler'] = $handler;

        $decorator = m::mock('JildertMiedema\Commander\CommandBus');
        $this->app['Decorator'] = $decorator;

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
        $this->app['TestHandler'] = $handler;

        $decorator = m::mock('StdClass');
        $this->app['Decorator'] = $decorator;

        $this->commandBus->decorate('Decorator');

        $command = m::mock('TestCommand');
        $this->commandBus->execute($command);
    }
}
