<?php

use PHPUnit\Framework\TestCase;

final class ControllerPluginsTest extends TestCase
{
    private function _getSut()
    {
        return new class
        {

        };
    }

    /**
     * @expectedException \Douma\ControllerPlugins\Exceptions\PluginNotFoundException
     */
    public function test_should_throw_exception_for_invalid_plugins(): void
    {
        $sut = $this->_getSut();
        $sut->invalidPlugin();
    }
}
