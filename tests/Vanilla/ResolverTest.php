<?php
namespace JildertMiedema\Commander\Vanilla;

class ResolverTest extends \PHPUnit_Framework_TestCase {

    public function testResolve()
    {
        require_once __DIR__ . '/../helpers/TestCommandHandler.php';

        $resolver = new Resolver();
        $object = $resolver->resolve('TestCommandHandler');

        $this->assertInstanceOf('TestCommandHandler', $object);
    }

    public function testCanResolveTrue()
    {
        require_once __DIR__ . '/../helpers/TestCommandHandler.php';

        $resolver = new Resolver();
        $result = $resolver->canResolve('TestCommandHandler');

        $this->assertTrue($result);
    }

    public function testCanResolveFalse()
    {
        require_once __DIR__ . '/../helpers/TestCommandHandler.php';

        $resolver = new Resolver();
        $result = $resolver->canResolve('UnknownClass');

        $this->assertFalse($result);
    }
}
