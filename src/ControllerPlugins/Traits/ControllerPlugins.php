<?php

namespace Douma\ControllerPlugins\Traits;
use Douma\ControllerPlugins\Exceptions\PluginNotFoundException;
use Illuminate\Contracts\Config\Repository;
use Douma\ControllerPlugins\Contracts;

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

    private function _getConfig() : Repository
    {
        $config = new \Illuminate\Config\Repository(config('controller_plugins') ?: []);
        return ($this->config !== null) ? $this->config : $config;
    }

    private function _pluginExists(string $name) : bool
    {
        foreach($this->_getConfig()->all() as $item) {
            if($item['name'] == $name) {
                return true;
            }
        }
        return false;
    }

    private function _createPlugin(string $name) : Contracts\ControllerPlugin
    {
        foreach($this->_getConfig()->all() as $item) {
            if($item['name'] == $name) {
                $plugin = app()->make($item['class']);
                $plugin->setConfig(isset($item['config']) ?
                    new \Illuminate\Config\Repository($item['config']) :
                    new \Illuminate\Config\Repository([])
                );
                return $plugin;
            }
        }
    }

    public function __call($method, $parameters)
    {
        if($this->_pluginExists($method)) {
            return $this->_createPlugin($method);
        } else throw PluginNotFoundException::forName($method);
    }
}
