<?php
namespace JildertMiedema\Commander\Silex;

use Silex\Application;
use JildertMiedema\Commander\ExecutorInterface;

class Executor implements ExecutorInterface
{

    use CommanderTrait {
        execute as traitExecute;
    }

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

    public function execute(
        $command,
        array $input = [],
        array $decorators = []
    ) {
        return $this->traitExecute($command, $input, $decorators);
    }


} 
