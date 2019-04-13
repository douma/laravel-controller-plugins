<?php

namespace Douma\ControllerPlugins\Exceptions;

class ConfigAlreadySetException extends \Exception
{
    public static function forPlugin(string $class) : self
    {
        return new self("Config already set for " . $class);
    }
}
