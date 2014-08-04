<?php
namespace JildertMiedema\Commander;

use \Mockery as m;

class ManagerTest extends \PHPUnit_Framework_TestCase {

    private $manager;
    private $commandBus;
    private $mapper;

    protected function setUp()
    {
        parent::setUp();
        $this->mapper = m::mock('JildertMiedema\Commander\Mapper');
        $this->commandBus = m::mock('JildertMiedema\Commander\CommandBus');
        $this->manager = new Manager($this->commandBus, $this->mapper);
    }

    protected function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    public function testGetCommandBus()
    {
        $commandBus = $this->manager->getCommandBus();
        $this->assertEquals($this->commandBus, $commandBus);
    }

    public function testGetMapper()
    {
        $mapper = $this->manager->getMapper();
        $this->assertEquals($this->mapper, $mapper);
    }

}
