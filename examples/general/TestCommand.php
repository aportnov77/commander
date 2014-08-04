<?php

class TestCommand {
    public $test;
    public $extra;

    public function __construct($test, $extra)
    {
        $this->test = $test;
        $this->extra = $extra;
    }
}
