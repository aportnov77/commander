<?php
namespace JildertMiedema\Commander\Silex;

use JildertMiedema\Commander\ResolverInterface;
use Silex\Application;

class Resolver implements ResolverInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function resolve($name)
    {
        return $this->app[$name];
    }

    public function canResolve($name)
    {
        return in_array($name, $this->app->keys());
    }
} 
