<?php

namespace Douma\ControllerPlugins\Contracts;

use Illuminate\Config\Repository;

interface ControllerPlugin
{
    public function setConfig(Repository $config);
}
