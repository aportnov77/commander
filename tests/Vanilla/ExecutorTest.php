<?php
namespace JildertMiedema\Commander\Vanilla;

use Mockery as m;

class ExecutorTest extends \PHPUnit_Framework_TestCase {

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testExecute()
    {
        $mapper = m::mock('StdClass');
        $command = m::mock('StdClass');
        $bus = m::mock('StdClass');

        $manager = m::mock('JildertMiedema\Commander\Manager');
        $manager->shouldReceive('getMapper')->andReturn($mapper);
        $manager->shouldReceive('getCommandBus')->andReturn($bus);

        $mapper->shouldReceive('mapInputToCommand')->once()->with('TestCommand', ['test' => '123'])->andReturn($command);

        $bus->shouldReceive('decorate')->once()->with('test');
        $bus->shouldReceive('execute')->once()->with($command)->andReturn('Result');

        $executor = new Executor($manager);

        $result = $executor->execute('TestCommand', ['test' => 123], ['test']);

        $this->assertEquals('Result', $result);
    }
}
