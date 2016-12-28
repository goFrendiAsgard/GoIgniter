<?php
namespace Modules\Test\Controllers;

use \Modules\Cms\Models\Genesis;
use \Module_Migrator;
use \Site_Detector;

class Test_site_detector extends \CI_Controller
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

        // run genesis
        $genesis = new Genesis();
        $genesis->set_db_config('password', 'toor');
        $genesis->set_db_config('database', 'tests'); 
        $genesis->setup();


        echo '<h4>Show site id</h4>';
        $site_detector = new Site_Detector();
        var_dump($site_detector->get_site_id());

        $this->teardown();
    }
}
