<?php

namespace JildertMiedema\Commander;

interface ExecutorInterface
{
    /**
     * @param string $command
     * @param array $input
     * @param array $decorators
     *
     * @return mixed
     */
    public function execute(
        $command,
        array $input = null,
        array $decorators = []
    );
}
