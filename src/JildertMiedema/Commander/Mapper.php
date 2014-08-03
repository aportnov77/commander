<?php
namespace JildertMiedema\Commander;

use ReflectionClass;
use InvalidArgumentException;

class Mapper
{
    /**
     * Map an array of input to a command's properties.
     * - Code courtesy of Taylor Otwell.
     *
     * @param  string $command
     * @param  array $input
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    public function mapInputToCommand($command, array $input)
    {
        $dependencies = [];

        $class = new \ReflectionClass($command);

        foreach ($class->getConstructor()->getParameters() as $parameter)
        {
            $name = $parameter->getName();

            if (array_key_exists($name, $input))
            {
                $dependencies[] = $input[$name];
            }
            elseif ($parameter->isDefaultValueAvailable())
            {
                $dependencies[] = $parameter->getDefaultValue();
            }
            else
            {
                throw new InvalidArgumentException("Unable to map input to command: {$name}");
            }
        }

        return $class->newInstanceArgs($dependencies);
    }
} 