<?php
namespace JildertMiedema\Commander;

class MapperTest extends \PHPUnit_Framework_TestCase {

    public function testMapper()
    {
        require_once(__DIR__. '/helpers/MapperTestHelper.php');
        $mapper = new Mapper();
        $class = $mapper->mapInputToCommand('MapperTestHelper', ['test' => '123']);

        $this->assertEquals('123', $class->test);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMapperWithException()
    {
        require_once(__DIR__. '/helpers/MapperTestHelper.php');
        $mapper = new Mapper();
        $mapper->mapInputToCommand('MapperTestHelper', []);
    }

    public function testMapperWithDefaultValue()
    {
        require_once(__DIR__. '/helpers/MapperTestDefaultHelper.php');
        $mapper = new Mapper();
        $class = $mapper->mapInputToCommand('MapperTestDefaultHelper', []);

        $this->assertEquals('456', $class->test);
    }

}
