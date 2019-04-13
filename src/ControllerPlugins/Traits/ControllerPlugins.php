<?php

namespace Douma\ControllerPlugins\Traits;
use Douma\ControllerPlugins\Exceptions\PluginNotFoundException;
use Illuminate\Contracts\Config\Repository;

trait ControllerPlugins
{
    /**
     * @var $config Repository
     */
    private $config=null;

    public function setConfig(Repository $config) : void
    {
        $this->config = $config;
    }

    private function _pluginExists(string $name) : bool
    {
        foreach($this->config->all() as $item) {
            if($item['name'] == $name) {
                return true;
            }
        }
        return false;
    }

    private function _createPlugin(string $name)
    {
        foreach($this->config->all() as $item) {
            if($item['name'] == $name) {
                return app()->make($item['class']);
            }
        }
    }

    public function __call($name, array $arguments)
    {
        if($this->_pluginExists($name)) {
            return $this->_createPlugin($name);
        } else throw PluginNotFoundException::forName($name);
    }
}
