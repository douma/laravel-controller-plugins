# Laravel Controller Plugins

## Installation

`composer require douma/laravel-controller-plugins`

### Service Provider

Register the following service provider:

`Douma\ControllerPlugins\ServiceProvider::class`

Publish the package example config:

`php artisan vendor:publish --provider="Douma\ControllerPlugins\ServiceProvider"`

## Introduction 

Laravel Controller Plugins are plugins that make it easier to remove complexity from controllers.
For example, one would write:

```php
class MyController
{
    public function index()    
    {
        $pageName = "Homepage";
        return view('index', ['pageTitle' => $this->pageTitle($pageName)]);
    }
    
    public function contactUs()    
    {
        $pageName = "Contact us";
        return view('index', ['pageTitle' => $this->pageTitle($pageName)]);
    }
    
    private function pageTitle(string $pageName) : string 
    {
        return "My Blog > " . $pageName;
    }
}
```

We create untestable private methods. Now we can chose to create a `Service` for
this but we can also chose to create a plugin for this, since page title
is not worthy of a service.

## Using controller plugins 

```php
use Douma\Traits\ControllerPlugins;

class MyController
{
    use ControllerPlugins;
    
    public function index()    
    {
        $this->pageTitle()->set("Homepage");
        return view('index');
    }
    
    public function contactUs()    
    {
        $this->pageTitle()->set("Homepage");
        return view('index');
    }
}
```

Plugins can return a return value just like any method can. But in this case 
the plugin shares a variable to the view.

```php
use Douma\ControllerPlugins\Plugins\BasePlugin;

class PageTitlePlugin extends BasePlugin
{
    //...
    
    public function set(string $name) : void 
    {
        view()->share('pageTitle', 'MyBlog > ' . $name);
    }
}
```

## Proxy & lazy loading 

The `pageTitle` is catched by a `magic method`, which tries to resolve the `pageTitle`
plugin name. It will lazy load the plugin when found in the configuration. 

## Configuration

The configuration specifies a plugin name, which will be the method to be called from the controller:

```php
//config/controller_plugins.php
return [
    [
        'name'=>'title',
        'class'=>Douma\ControllerPlugins\Plugins\PageTitle::class,
        'config'=>[
            'title'=>'MySite.com | %s'
        ]
    ]
];

```

### Config

The `config`-namespace allows you to define extra configuration parameters
which will be passed into the `__construct` of the plugin:

```php
use Douma\ControllerPlugins\Plugins\BasePlugin;

class PageTitlePlugin extends BasePlugin
{
    private $config;
    
    public function __construct(Container $config)
    {
        $this->config = $config;
    }
    
    public function set(string $name) : void 
    {
        view()->share('pageTitle', sprintf($this->config->get('title'), $name));
    }
}
```

## Testing

Plugins are easy to test. Controllers are tested through integration tests, while the plugin can be tested
through a unit test.
