<?php
use JildertMiedema\Commander\ValidationInterface;

class TestCommandValidator implements ValidationInterface
{

    public function validate($command)
    {
        var_dump('validate');

        if (!$command->test) {
            throw new ValidationException(sprintf('error in %s::test', get_class()));
        }
        if (!$command->extra) {
            throw new ValidationException(sprintf('error in %s::extra', get_class()));
        }

        return true;
    }

} 
