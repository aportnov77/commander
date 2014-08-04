<?php
namespace JildertMiedema\Commander\Silex;

use Mockery as m;
use Silex\Application;

class ExecutorTest extends \PHPUnit_Framework_TestCase {

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }


    public function testExecute()
    {
        $app = new Application();

        $mapper = m::mock('StdClass');
        $command = m::mock('StdClass');
        $bus = m::mock('StdClass');
        $app['commander.manager'] = m::mock('JildertMiedema\Commander\Manager');
        $app['commander.manager']->shouldReceive('getMapper')->andReturn($mapper);
        $app['commander.manager']->shouldReceive('getCommandBus')->andReturn($bus);
        $mapper->shouldReceive('mapInputToCommand')->once()->with('TestCommand', ['test' => '123'])->andReturn($command);
        $bus->shouldReceive('decorate')->once()->with('test');
        $bus->shouldReceive('execute')->once()->with($command)->andReturn('Result');

        $executor = new Executor($app);

        $result = $executor->execute('TestCommand', ['test' => 123], ['test']);

        $this->assertEquals('Result', $result);
    }

}
