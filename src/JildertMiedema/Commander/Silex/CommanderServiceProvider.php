<?php
namespace JildertMiedema\Commander\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;
use JildertMiedema\Commander\Mapper;
use JildertMiedema\Commander\Manager;

class CommanderServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services for the command bus
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $app['commander.manager'] = $app->share(function() use ($app) {
            $mapper = new Mapper();
            $translator = new CommandTranslator();
            $defaultCommandBus = new DefaultCommandBus($app, $translator);
            $commandBus = new ValidationCommandBus($defaultCommandBus, $app, $translator);
            return new Manager($mapper, $commandBus);
        });
    }

    /**
     * Nothing to do here
     */
    public function boot(Application $app)
    {

    }

} 
