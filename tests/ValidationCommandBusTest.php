<?php
namespace JildertMiedema\Commander\Silex;

use Mockery as m;

class ValidationCommandBusTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var Silex\Application
     */
    private $app;

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

        $this->app = new \Silex\Application();
        $this->translator = m::mock('JildertMiedema\Commander\Silex\CommandTranslator');
        $this->defaultCommandBus = m::mock('JildertMiedema\Commander\Silex\DefaultCommandBus');

        $this->commandBus = new ValidationCommandBus(
            $this->defaultCommandBus,
            $this->app,
            $this->translator
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
        $this->app['Validator'] = $validator;

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
        $this->app['Validator'] = $validator;

        $decorator = m::mock('JildertMiedema\Commander\CommandBus');
        $this->app['Decorator'] = $decorator;

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
