# Domain commander
=========

This package is able run domain commands easily. Commands are used to separate domain logic from your php framework.

This package is based on [Laravel Commander](https://github.com/laracasts/Commander) build by [JeffreyWay](https://github.com/JeffreyWay).

## Installation

Install through Composer.

```js
"require": {
    "jildertmiedema/commander": "~0.1"
}
```

## What does it do
 * It creates a command object. The command object is [data transfer object](http://en.wikipedia.org/wiki/Data_transfer_object) between the framework/controller and the domain logic.
 * It will fill the command object with the request data (For example `$_GET`, `$_POST`, `$app['request']->query->all()`).
 * It will try to find a validator class, when it's found it will validate the input.
 * If decorators have been set it will execute the decorators. (For example a sanitizer).
 * It will find and execute the handler for the command.


## Integrate to the framework

### Silex
This package can easily be used in [Silex](http://silex.sensiolabs.org).

It will try to find a handler(required) and a validator (not required) from application container using the following convention.
```php
//without namespace "ExampleCommand"
$app[$className . '.handler']; // exampleCommand.handler
$app[$className . '.validator']; // exampleCommand.validator

//with namespace "Acme\Domain\ExampleCommand"
$app[$className . '.handler']; // acme.domain.exampleCommand.handler
$app[$className . '.validator']; // acme.domain.exampleCommand.validator
```

Usage:
```php
$app->register(new JildertMiedema\Commander\Silex\CommanderServiceProvider());
```

Example:
```php
class TestCommand {
    public $test;
    public $extra;

    public function __construct($test, $extra)
    {
        $this->test = $test;
        $this->extra = $extra;
    }
}

class TestCommandHandler implements CommandHandler
{

    public function handle($command)
    {
        //handle the command
    }
}

$app['testCommand.handler'] = $app->share(function() use ($app) {
    return new TestCommandHandler();
});

$app->get('/', function() use ($app) {
    return $app['commander.executor']->execute('TestCommand');
});
```
For a full example see [silex.php](https://github.com/jildertmiedema/commander/blob/master/examples/silex.php)

For usage in controllers see [CommanderController.php](https://github.com/jildertmiedema/commander/blob/master/examples/silex/CommanderController.php)

### Vanilla php
To use commander in another framework you can use this code:
```php
use JildertMiedema\Commander\Manager;
use JildertMiedema\Commander\Vanilla\Executor;

$manager = new Manager();
$executor = new Executor($manager);

echo $executor->execute('TestCommand', null, ['TestSanitizer']);
```
> The vanilla php solution does not support out-of-the-box dependency injection, therefore you need to implement a translator and a resolver.

An example [vanilla.php](https://github.com/jildertmiedema/commander/blob/master/examples/vanilla.php)

### Creating your own translator and resolver
For integration with a another framework you can implement your own `translator` and `resolver`.

```php
$translator = new YourOwnCommandTranslator; // Must implement `JildertMiedema\Commander\CommandTranslatorInterface`
$resolver =  new YourOwnResolver; // Must implement `JildertMiedema\Commander\ResolverInterface`
$defaultCommandBus = new DefaultCommandBus($translator, $resolver);
$commandBus = new ValidationCommandBus($defaultCommandBus, $translator, $resolver);
$manager = new Manager($commandBus);
```

### Examples

Run the examples
```sh
cd YOUR_PACKAGE_DIR
cd examples
php -S localhost:8000
```

Visit:
```
http://localhost:8000/silex.php?test=test%20%20%20&extra=123
http://localhost:8000/silex.php/sanitizer?test=test%20%20%20&extra=123
http://localhost:8000/silex.php/controller?test=test%20%20%20&extra=123
http://localhost:8000/vanilla.php?test=test%20%20%20&extra=123
```
