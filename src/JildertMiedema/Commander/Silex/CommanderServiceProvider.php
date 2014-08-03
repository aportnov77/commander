<?php
namespace JildertMiedema\Commander\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;
use JildertMiedema\Commander\Mapper;
use JildertMiedema\Commander\Manager;

class CommanderServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
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
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }

} 