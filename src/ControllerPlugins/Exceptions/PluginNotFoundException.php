<?php

namespace Douma\ControllerPlugins\Exceptions;

class PluginNotFoundException extends \Exception
{
    public static function forName(string $name) : self
    {
        return new self("Plugin not found for name " . $name);
    }
}
