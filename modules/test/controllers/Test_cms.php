<?php
namespace Modules\Test\Controllers;

use \Modules\Cms\Models\Genesis;
use \Module_Migrator;
class Test_cms extends \CI_Controller
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

    public function index()
    {
        $this->delete_configs();
        $genesis = new Genesis();

        $genesis->set_db_config('database', 'tests'); 
        $genesis->set_db_config('password', 'toor');

        if($genesis->setup())
        {
            $this->load->helper('url');
            redirect('test/test_cms/real_test');
        }
        else
        {
            var_dump('something is wrong');
        }
    }

    public function real_test()
    {
        echo '<h4>Show $this->db->conn_id</h4>';
        $this->load->database();
        var_dump($this->db->conn_id);

        echo '<h4>Try Module_Migrator</h4>';
        $migrator = new Module_Migrator();
        $migrator->migrate();
    }


}
