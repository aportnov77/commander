<?php

namespace JildertMiedema\Commander;

interface CommandTranslatorInterface
{
    public function toCommandHandler($command);
    public function toValidator($command);
}