<?php
namespace Modules\Test\Controllers;

use \Modules\Cms\Models\Genesis;
use \Module_Migrator;

class Test_module_migration extends \CI_Controller
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

        echo '<h4>Show $this->db->conn_id</h4>';
        $this->load->database();
        var_dump($this->db->conn_id);

        echo '<h4>Try Module_Migrator</h4>';
        $migrator = new Module_Migrator();
        $migrator->migrate_all();
        var_dump($migrator->get_error());

        $this->teardown();
    }
}
