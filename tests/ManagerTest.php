<?php
namespace JildertMiedema\Commander;

use \Mockery as m;

class ManagerTest extends \PHPUnit_Framework_TestCase {

    private $commandBus;
    private $mapper;

    protected function setUp()
    {
        parent::setUp();
        $this->mapper = m::mock('JildertMiedema\Commander\Mapper');
        $this->commandBus = m::mock('JildertMiedema\Commander\CommandBus');
    }

    protected function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    public function testGetCommandBus()
    {
        $manager = new Manager($this->commandBus, $this->mapper);
        $commandBus = $manager->getCommandBus();
        $this->assertEquals($this->commandBus, $commandBus);
    }

    public function testGetMapper()
    {
        $manager = new Manager($this->commandBus, $this->mapper);
        $mapper = $manager->getMapper();
        $this->assertEquals($this->mapper, $mapper);
    }

    public function testGetDefaultCommandBus()
    {
        $manager = new Manager();
        $commandBus = $manager->getCommandBus();
        $this->assertInstanceOf('JildertMiedema\Commander\ValidationCommandBus', $commandBus);
    }

}
