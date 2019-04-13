<?php

namespace Douma\ControllerPlugins\Plugins;

class PageTitle extends BasePlugin
{
    public $view = 'view';

    public function set(string $name) : void
    {
        $pageTitle = sprintf($this->_getConfig()->get('title') ?: "%s", $name);
        call_user_func($this->view)->share('pageTitle', $pageTitle);
    }
}
