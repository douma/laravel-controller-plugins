<?php

use Illuminate\Contracts\Config\Repository;

final class TitlePluginTest extends \Tests\TestCase
{
    public function test_should_pass_pageTitle_to_view()
    {
        $sut = new \Douma\ControllerPlugins\Plugins\PageTitle(new \Illuminate\Config\Repository([
            'title'=>'MySite | %s'
        ]));
        $sut->setConfig(new \Illuminate\Config\Repository([
            'title'=>'Test | %s'
        ]));
        $sut->view = [$this, 'shareShunt'];
        $sut->set("Page title");

        $this->assertEquals('pageTitle', $this->param);
        $this->assertEquals('Test | Page title', $this->value);
    }

    public function shareShunt()
    {
        return $this;
    }

    public $param, $value;
    public function share($param, $value)
    {
        $this->param = $param;
        $this->value = $value;
    }
}
