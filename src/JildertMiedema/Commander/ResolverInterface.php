<?php

namespace JildertMiedema\Commander;

interface ResolverInterface
{

    /**
     * @param string $name
     *
     * @return object
     */
    public function resolve($name);

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function canResolve($name);
}
