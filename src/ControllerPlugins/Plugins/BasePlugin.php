<?php

namespace Douma\ControllerPlugins\Plugins;

use Illuminate\Contracts\Config\Repository;
use Douma\ControllerPlugins\Exceptions;

abstract class BasePlugin
{
    private $config = null;

    final public function setConfig(Repository $config)
    {
        if($this->config !== null) {
            throw Exceptions\ConfigAlreadySetException::forPlugin(get_called_class());
        }
        $this->config = $config;
    }

    protected function _getConfig() : Repository
    {
        return $this->config;
    }
}
