# GoIgniter

An attempt to extend CodeIgniter3 without breaking all the good things. You can play around with it before CodeIgniter4 is ready, and you can still play around with it after CodeIgniter4 is ready. By using GoIgniter, you can do cool stuff without breaking your current working code.

Every code works in CodeIgniter3 will also works in GoIgniter.

Personally, I made this as core foundation of No-CMS 2.0

# Philosophy

* Perfection is simply never exists.

    CodeIgniter3 is doing it right by supporting migration. In fact, it is almost impossible to write a script that is 100% working without any attempt to fix it later. Instead of trying to do so, build the simplest part possible, and gradually scale it.

* If something is not broken, don't fix it.

    CodeIgniter3 is stable enough. Some new technologies such as namespace might not be used extensively. The `$this->load->model()` might be ugly, but it has work since 2010, so let it be.

* If something is broken (outdated), find out which part exactly it is, and only fix/improve that part.

    Sometime recode things from scratch is necessary, but most of the time, you can just extend and improve.

* Do as little changes as possible, and only do it when necessary.

    You are lazy, it is good, and you should keep it that way :)

# Minimum requirement

* PHP 5.3, since I use `anonymous function`

# How to start

* If you use xampp, put this on `C:\xampp\htdocs`, open your browser, and type this url: `http://localhost/GoIgniter`
* If you want to use php's default server, type `php amigo serve` in your terminal, open your browser, and type this url: `http://localhost:8080`

# Feature

* HMVC with namespace
* run_module_controller() which is better than HMVC's `Modules::run`
* static file management with `asset_url()`
* The way of initiating helper, model, or library is very similar to CodeIgniter4
* Still compatible with PHP 5.4 (Contrast to CodeIgniter4 that will only support PHP7)
* Extended routes (including option to disable autoroute)
* Extended config
* Better Unit Test Library 

# Modified files

These are some files that was modified or added in GoIgniter:

* `assets/`
* `composer.json` (This file is different from CodeIgniter's, please make sure to not overwrite this when you update CodeIgniter)
* `index.php` (This file is different from CodeIgniter's, please make sure to not overwrite this when you update CodeIgniter)
* `application/core/config/`
* `application/core/go_init.php`
* `application/core/Module_Migrator.php`
* `application/core/MY_CodeIgniter.php`
* `application/core/MY_Config.php`
* `application/core/MY_Loader.php`
* `application/core/MY_Router.php`
* `application/core/Go_Model.php`
* `application/core/Unit_test.php`
* `application/views/modules/`

# The cool things

GoIgniter let you have HMVC structure without using HMVC Plugin, However the HMVC style is a bit different from the original.

```php
    <?php // file location: modules/test/controllers/Mycontroller.php
    namespace Modules\Test\Controllers;

    class Mycontroller extends \CI_Controller{

        function index(){
            $model = new \Modules\Test\Models\MyModel();
            helper('test/date');
            $data = array(
                    'articles' => $model->get_data(),
                    'date'     => get_date()
                    );
            view('test/MyView', $data);
        }

        function harambe($act){
            echo 'All hail harambe !!!'.PHP_EOL;
            echo 'Harambe is '.$act;
            if(isset($_GET['food']))
            {
                echo PHP_EOL . 'Give ' . $_GET['food'] . ' to harambe';
            }
        }

    }
```

First, look at the controller. Pretty similar to normal CodeIgniter's. But as many cool PHP framework out there, here, you should use `namespace`. At first, this might looks like an extra works, but this will gives you at least two advantages:

* You no longer need to worry about class collision
* Switching to other cool framework out there (laravel, symfony, codeigniter4, etc) will be easier

Also, now you do `$model = new \Modules\Test\Models\MyModel();` instead of `$this->load->model('mymodel');`. This is also a good practice. Err, actually no, the best practice is this:

```php
    <?php // file location: modules/test/controllers/Mycontroller.php
    namespace Modules\Test\Controllers;
    use \Modules\Test\Models\MyModel as Model;

    class Mycontroller extends \CI_Controller{
        function index()
        {
            $model = new Model();
            // and the rest of your code
        }
    }

```

This make things more explicit, as well as avoiding class collision. And if you don't want to change your coding style too much, you can also use this `$this->model = new Model();`.

If you take a closer look, you will also notice, that we now use `helper('helper_name')` and `view('view_name')` instead of `$this->load->helper('helper_name')` and `$this->load->view('view_name')`. 

Too much changes? Don't worry, try to put any model, view, and controller in your `application`, and you can load them all just as the original CodeIgniter!!!

That's cool, but you will see something cooler in the `view`.

```php 
<!-- file location: modules/test/views/MyView.php -->
<h1>Hello world</h1>
<h2><?=$date?></h2>
<?php 
foreach($articles as $article){
    echo '<h4>' . $article['title'] . '</h4>';
    echo $article['content'];
}

echo '<pre>';
run_module_controller('test/mycontroller/harambe/run?food=banana');
echo '</pre>';

var_dump($_GET)
?>
```

Yes, you have `run_module_controller` function, that can be called anywhere!!!

Some people hate it. In case of you hate it, just don't use it. However, in many workflow (as if you want to make widget mechanism, which the widget can also be accessed as independent page), this is going to be very useful.

You can also put some `GET` query when running other controller, and the original `$_GET` value won't be affected.

For example, I try to access this url `http://localtest.me/GoIgniter/index.php/test/mycontroller?food=pancake`. And I get this as the result:

```
    Hello world
    2016-12-24
    Sun
    Closest sun
    Moon
    Rock

    All hail harambe !!!
    Harambe is 'run'
    Give banana to harambe

    /home/gofrendi/public_html/GoIgniter/application/views/modules/test/MyView.php:13:
    array (size=1)
      'food' => string 'pancake' (length=7)

```

Firstly, `$_GET["food"]` contains `pancake`. But when you call `test/mycontroller/harambe/run?food=banana`, `$_GET["food"]` is changed to `banana`. Later, when you run `var_dump($_GET)`, it will give you a `pancake`.

# Per Module Migration

CodeIgniter was built with single MVC in mind. While this make things simple, sometime, we really need to separate our codes into several modules. When it come to database migration, it should works the same way. In GoIgniter, you can perform per-module-migration by doing this:

```php
    <?php // file location: modules/test/controllers/Test_migration
    namespace Modules\Test\Controllers;

    use \Module_Migrator;
    class Test_migration extends \CI_Controller
    {
        function index()
        {
            $migrator = new Module_Migrator();
            $migrator->migrate_all();

            // you can also do this:
            // $migrator->migrate_all('current', array('test' => 0, 'cms' => '20161030'))
            // This will only migrate test to version 0, and cms to version 20161030

            // you can also do this:
            // $migrator->migrate('blog', 'current', 0)
            // This will only migrate blog to version 0
        }
    }
```

# Extended Configuration

In GoIgniter, you can extend CodeIgniter's configuration by creating `application/core/config/config.php`.
While this is not as convenient as `.env` in CodeIgniter4 or Laravel, this can help you a lot. Since `config.php` is just another php script, I can do everything here. Load an independent json file seems to be more convenient than put your configuration in `application/config/` and accidentally overwrite it...

```php
    <?php defined('BASEPATH') OR exit('No direct script access allowed');

    // This was created by cms module's Genesis 
    $_cms_config_file = MODULEPATH.'cms/json/configuration.json';
    if(file_exists($_cms_config_file))
    {
        $_json = file_get_contents($_cms_config_file);
        $_cms_config = json_decode($_json, TRUE);
        foreach($_cms_config as $key=>$val)
        {
            $config[$key] = $val;
        }
    }
```

Two new keys are introduced in extended configuration:

* `$config['hostname']`
* `$config['asset_url']` 

Also, you can extend database configuration here, by doing something like:

* `$config['db.default.database'] = 'tests';` As, you've notice, `default` is database active group.

Not only database, you can also overwrite all codeigniter's library's configuration here. For example you want to change `migration_table` into `'cms_migration'`. Here is how you do that: `$config['migration.migration_table'] = 'cms_migration';`

# Extended Route

In GoIgniter, you can also extend CodeIgniter's routing by creating `application/core/config/routes.php`.
This will override any route configuration defined in `application/config/routes.php`.

Also, `$route['disable_autoroute']` is now introduced. Set it to FALSE, and no magical autorouting anymore.
Beware, if you set `$route['disable_autoroute']`, even default controller route will not work, and you have to define `$route['']` to your `supposed-to-be-default-controller` instead.

# Constants

Three new constants are introduced in GoIgniter.

* MODULEPATH
* ASSETPATH
* EXTCONFIGPATH

You can change the values by editing `index.php`


# Always loaded functions

These functions are always available, either in models, views, or controllers

* `asset_url($url = '', $protocol = NULL)`
* `site_url($url = '', $protocol = NULL)` --> This will also detect multisite
* `base_url($url = '', $protocol = NULL)`
* `cache_file($src_file, $dst_file)` 
* `get_available_modules()`
* `helper($helpers = array())`
* `view($view, $data = array(), $return = FALSE)`
* `run_module_controller($url, $return = FALSE)`
* `run_routed_module($url, $return = FALSE)`
* `cache_modules()

# Soon to be added

* CMS Module
* Amigo (kind of Artisan in Laravel)
* Unit testing (Failed)
* CodeIgniter4 like Model & Entity
* Multisite
* Laravel's like blade engine (No need, use twig instead)

# The bad things

* I made `application\views\modules\` to cache the original view. Whenever original view updated, and someone access the url, the cache will be updated. This is good, and I also check modification time of the file, so there is no unnecessary `write-to-disk` operation. But it surely add several micro seconds to response time. The same mechanism also works for asset (static file) management.

* There might be some 'reinventing-the-wheel' thing here.
