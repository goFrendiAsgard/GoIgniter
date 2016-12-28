<?php
namespace Modules\Test\Controllers;

use \Modules\Cms\Models\Genesis;

class Test_cms_genesis extends \CI_Controller
{

    protected function delete_configs()
    {
        if(file_exists(EXTCONFIGPATH.'config/config.php'))
        {
            unlink(EXTCONFIGPATH.'/config/config.php');
        }

        if(file_exists(MODULEPATH.'cms/json/configuration.json'))
        {
            unlink(MODULEPATH.'cms/json/configuration.json');
        }
    }

    protected function setup()
    {
        $this->delete_configs();
    }

    protected function teardown()
    {
        $this->delete_configs();
    }

    public function index()
    {
        $this->setup();

        echo '<h4>Create Genesis, should yield no error</h4>';
        $genesis = new Genesis();

        echo '<p>The following tests assume you have database `tests` in your `localhost`, you have `root` user, and the password is `toor`</p>';

        echo '<h4>genesis->is_db_valid(), connect to mysql root@localhost/tests, pwd:tor, should yield false</h4>';
        var_dump($genesis->is_db_valid());
        $genesis->set_db_config('password', 'tor');
        $genesis->set_db_config('database', 'tests'); 
        
        echo '<h4>genesis->is_db_valid(), connect to mysql root@localhost/tests, pwd:toor, should yield true</h4>';
        $genesis->set_db_config('password', 'toor');
        var_dump($genesis->is_db_valid());

        echo '<h4><genesis->setup(), should yield no error</h4>';
        var_dump($genesis->setup());

        echo '<h4>Load the config, should yield true and bunch of config value. Value of db_user, db_password etc should be set correctly. Value of sess_cookie_name and encryption_key should be random.</h4>';
        var_dump($this->load->config('config'));
        var_dump($this->config->config);

        $this->teardown();
    }

}
