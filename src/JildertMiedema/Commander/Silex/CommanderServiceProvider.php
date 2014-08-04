<?php
namespace JildertMiedema\Commander\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;
use JildertMiedema\Commander\Mapper;
use JildertMiedema\Commander\Manager;
use JildertMiedema\Commander\DefaultCommandBus;
use JildertMiedema\Commander\ValidationCommandBus;

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
            $resolver = new Resolver($app);
            $defaultCommandBus = new DefaultCommandBus($translator, $resolver);
            $commandBus = new ValidationCommandBus($defaultCommandBus, $translator, $resolver);
            return new Manager($commandBus, $mapper);
        });

        $app['commander.executor'] = $app->share(function() use ($app) {
            return new Executor($app);
        });
    }

    /**
     * Nothing to do here
     */
    public function boot(Application $app)
    {

    }

} 
