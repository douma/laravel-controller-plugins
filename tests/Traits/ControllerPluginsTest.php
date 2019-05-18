<?php

use Douma\ControllerPlugins\Exceptions\PluginNotFoundException;
use Douma\ControllerPlugins\Traits\ControllerPlugins;
use Douma\ControllerPlugins\Contracts;
use Illuminate\Config\Repository;

class ValidPlugin implements Contracts\ControllerPlugin
{
    public function test()
    {
        return 1;
    }

    public function setConfig(Repository $config){}
}

final class ControllerPluginsTest extends \Tests\TestCase
{
    private function _getSut()
    {
        return new class
        {
            use ControllerPlugins;
        };
    }

    public function test_should_match_plugin_based_on_config()
    {
        $config = new Illuminate\Config\Repository([[
            'name'=>'validPlugin',
            'class'=>'ValidPlugin'
        ]]);
        $sut = $this->_getSut();
        $sut->setConfig($config);
        $sut->validPlugin();
    }

    /**
     * @expectedException \Douma\ControllerPlugins\Exceptions\PluginNotFoundException
     */
    public function test_should_throw_exception_for_invalid_plugins(): void
    {
        $sut = $this->_getSut();
        $sut->setConfig(new \Illuminate\Config\Repository([]));
        $sut->invalidPlugin();
    }

    public function test_should_run_plugin()
    {
        $config = new \Illuminate\Config\Repository([[
            'name'=>'validPlugin',
            'class'=>ValidPlugin::class
        ]]);
        $sut = $this->_getSut();
        $sut->setConfig($config);
        $this->assertEquals(1, $sut->validPlugin()->test());
    }

    public function test_should_call_plugin_same_instance()
    {
        $config = new \Illuminate\Config\Repository([[
            'name'=>'validPlugin',
            'class'=>ValidPlugin::class
        ]]);
        $sut = $this->_getSut();
        $sut->setConfig($config);
        $this->assertSame($sut->validPlugin(), $sut->validPlugin());
    }
}
