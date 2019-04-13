<?php

namespace Douma\ControllerPlugins\Plugins;

use Illuminate\Config\Repository;
use Douma\ControllerPlugins\Exceptions;
use Douma\ControllerPlugins\Contracts;

abstract class BasePlugin implements Contracts\ControllerPlugin
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
