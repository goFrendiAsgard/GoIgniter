# GoIgniter

An attempt to extends CodeIgniter3 without making it too funky. You can play around with it before CodeIgniter4 is ready, and you can still play around with it after CodeIgniter4 is ready. By using GoIgniter, you can do cool stuff without breaking your current working code.

Every code works in CodeIgniter3 will also works in GoIgniter.

Personally, I made this as core foundation of No-CMS 2.0

# Feature

* HMVC with namespace
* static file management with `asset_url()`
* The way of initiating helper, model, or library is very similar to CodeIgniter4
* Still compatible with PHP 5.4 (CodeIgniter4 will only support PHP7)


# Modified files

These are some files that was modified or added in GoIgniter:

* `assets/`
* `index.php`
* `application/core/config/`
* `application/core/go_init.php`
* `application/core/MY_CodeIgniter.php`
* `application/core/MY_Config.php`
* `application/core/MY_Router.php`
* `application/core/Go_Model.php`
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

First, look at the controller. Pretty similar to normal CodeIgniter's. But as many cool PHP framework out there, here, you should use `namespace`. At first, this might looks like an extra works, but this will gives you at least two advantage:

* You no longer need to worry about class colition
* Switching to other cool framework out there (laravel, symfony, codeigniter4, etc) will be easier

Also, now you do `$model = new \Modules\Test\Models\MyModel();` instead of `$this->load->model('mymodel');`. This is also a good practice. Err, actually no, the best practice is this:

```php
    <?php
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

This make things more explicit, as well as avoiding class colition. And if you don't want to change your coding style too much, you can also use this `$this->model = new Model();`.

If you take a closer look, you will also notice, that we now use `helper('helper_name')` and `view('view_name')` instead of `$this->load->helper('helper_name')` and `$this->load->view('view_name')`. 

Too much changes? Don't worry, try to put any model, view, and controller in your `application`, and you can load them all just as the original CodeIgniter!!!

That's cool, but you will see something cooler in the `view`.

```php
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

# Soon to be added

* CodeIgniter4 like Model & Entity
* Multisite
* Laravel's like blade engine
* Unit testing

# The bad things

* I made `application\views\modules\` to cache the original view. Whenever original view updated, and someone access the url, the cache will be updated. This is good, and I also check modification time of the file, so there is no unnecessary `write-to-disk` operation. But it surely add several micro seconds to response time.

* There might be some 'reinventing-the-wheel' thing here.
