<?php
namespace JildertMiedema\Commander\Vanilla;

use JildertMiedema\Commander\ResolverInterface;

class Resolver implements ResolverInterface
{

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function canResolve($name)
    {
        return class_exists($name);
    }


    /**
     * @param string $name
     *
     * @return object
     */
    public function resolve($name)
    {
        return new $name();
    }

} 
