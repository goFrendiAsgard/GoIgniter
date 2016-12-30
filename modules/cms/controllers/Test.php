<?php
namespace Modules\Cms\Controllers;

use \Module_Migrator;
use \Site;
use \Modules\Cms\Models\Genesis;
use \Modules\Cms\Test_Controller;
use \Modules\Cms\Mutator;

class Test extends Test_Controller 
{
    function reset()
    {
        // undo mutation
        $mutator = new Mutator();
        $mutator->undo_mutation();

        // delete all site
        $site = new Site();
        foreach($site->get_available_site_codes() as $code)
        {
            $site->delete_site($code);
        }

    }

    function global_setup()
    {
        $this->reset();
    }

    function global_tearDown()
    {
        $module_migrator = new Module_Migrator();
        $module_migrator->migrate_all('current');

        $this->reset();

        !file_exists(MODULEPATH.'cms/.mutation') || unlink(MODULEPATH.'cms/.mutation');
        !file_exists(MODULEPATH.'cms/.genesis') || unlink(MODULEPATH.'cms/.genesis');
        !file_exists(MODULEPATH.'cms/mutation_backup/config.php.bak') || unlink(MODULEPATH.'cms/mutation_backup/config.php.bak');
        !file_exists(MODULEPATH.'cms/mutation_backup/config.php.bak') || unlink(MODULEPATH.'cms/mutation_backup/config.php.bak');
        !file_exists(EXTCONFIGPATH.'config/config.php') || unlink(EXTCONFIGPATH.'config/config.php');
        !file_exists(EXTCONFIGPATH.'config/route.php') || unlink(EXTCONFIGPATH.'config/route.php');
    }
    
    function test_mutation()
    {
        $mutator = new Mutator();

        // Undo mutation should not work
        $test = $mutator->undo_mutation();
        $this->unit->run($test, FALSE, 'Undo Mutation should not work at the first time');

        $test = $mutator->get_error_message();
        $this->unit->run($test, 'Cannot undo mutation, mutation has not been performed', 'Error message should be set');

        // Mutation should work
        $test = $mutator->do_mutation();
        $this->unit->run($test, TRUE, 'Mutation should work at the first time');

        $test = $mutator->get_error_message();
        $this->unit->run($test, '', 'Error message should not be set');

        // Mutation again should not work
        $test = $mutator->do_mutation();
        $this->unit->run($test, FALSE, 'Mutation should not work anymore since it has been performed');

        $test = $mutator->get_error_message();
        $this->unit->run($test, 'Cannot do mutation, mutation has already performed', 'Error message should not be set');

        // Undo mutation should now work
        $test = $mutator->undo_mutation();
        $this->unit->run($test, TRUE, 'Undo Mutation should now work');

        $test = $mutator->get_error_message();
        $this->unit->run($test, '', 'Error message should not be set');

        // Mutation again should work
        $test = $mutator->do_mutation();
        $this->unit->run($test, TRUE, 'Mutation should work after undo mutation has been performed');

        $test = $mutator->get_error_message();
        $this->unit->run($test, '', 'Error message should not be set');
    }

    function test_cms_genesis()
    {
        $genesis = new Genesis();

        // Test $genesis->is_db_valid()
        $test = $genesis->is_db_valid();
        $expected_result = FALSE;
        $this->unit->run($test, $expected_result, 'Before anything done, $genesis->is_db_valid() should yield FALSE');

        $db_user = $this->input->get('user');
        $db_password = $this->input->get('password');
        $db_database = $this->input->get('database');
        if($db_user === NULL) $db_user = 'root';
        if($db_password === NULL) $db_password = 'toor';
        if($db_database === NULL) $db_database = 'tests';

        $notes = 'You can pass user, password, and database get query to override database setting, i.e: ?user=root&password=&database=mydb. By default this test use Mysql, user:root, password:toor, database:tests. The database should be empty';

        // Test $genesis->setup()
        $genesis->set_db_config('user', $db_user);
        $genesis->set_db_config('password', $db_password);
        $genesis->set_db_config('database', $db_database);

        $test = $genesis->setup();
        $expected_result = TRUE;
        $this->unit->run($test, $expected_result, 'genesis->setup() should yield TRUE', $notes);

        // Connection works
        $this->load->database();
        $test = $this->db->conn_id !== FALSE;
        $expected_result = TRUE;
        $this->unit->run($test, $expected_result, 'DB connection should work after genesis set');

        // Test configurations
        $this->load->config('config');
        
        $this->load->config('config');
        $config = $this->config->config;
        $expected_result = TRUE;

        $test = $config['hostname'] == $_SERVER['SERVER_NAME'];
        $notes = 'hostname : ' . $config['hostname'];
        $this->unit->run($test, $expected_result, 'hostname should equals SERVER_NAME', $notes);

        $test = $config['sess_cookie_name'] != '';
        $notes = 'sess_cookie_name : ' . $config['sess_cookie_name'];
        $this->unit->run($test, $expected_result, 'sess_cookie_name is not empty', $notes);

        $test = $config['encryption_key'] != '';
        $notes = 'encryption_key : ' . $config['encryption_key'];
        $this->unit->run($test, $expected_result, 'encryption_key is not empty', $notes);

    }

    function test_config()
    {

        $config = $this->config->config;

        $expected_result = $_SERVER['SERVER_NAME'];
        $test = $config['hostname'];
        $this->unit->run($test, $expected_result, 'config.hostname has been set correctly');
    }

    function get_tables()
    {
        $result = $this->db->query('SHOW TABLES')->result();
        $tables = array();
        foreach($result as $row)
        {
            foreach($row as $key=>$val)
            {
                $tables[] = $val;
            }
        }
        return $tables;
    }

    function test_migrator()
    {
        $migrator = new Module_Migrator();

        // Migrate All without parameter
        $migrator->migrate_all();
        $errors = $migrator->get_error();

        $test = $errors['cms'];
        $expected_result = '';
        $this->unit->run($test, $expected_result, '$migrate->migrate_all()');

        $tables = $this->get_tables();
        $test = count($tables) > count(get_available_modules());
        $expected_result = TRUE;
        $notes = 'Table : '.implode(', ', $tables);
        $this->unit->run($test, $expected_result, 'Count of table should be more than count of available modules', $notes);

        // Migrate All with current mode 
        $migrator->migrate_all('current');
        $errors = $migrator->get_error();

        $test = $errors['cms'];
        $expected_result = '';
        $this->unit->run($test, $expected_result, '$migrate->migrate_all("current")');

        $tables = $this->get_tables();
        $test = count($tables) == count(get_available_modules());
        $expected_result = TRUE;
        $notes = 'Table : '.implode(', ', $tables);
        $this->unit->run($test, $expected_result, 'Count of table should be equal to count of available modules', $notes);

        // Test DB Migration
        $migrator->migrate('cms');
        $errors = $migrator->get_error();

        $test = $errors['cms'];
        $expected_result = '';
        $this->unit->run($test, $expected_result, '$migrate->migrate("cms")');

        $tables = $this->get_tables();
        $test = count($tables) > count(get_available_modules());
        $expected_result = TRUE;
        $notes = 'Table : '.implode(', ', $tables);
        $this->unit->run($test, $expected_result, 'Count of table should be more than count of available modules', $notes);

}

    function test_site()
    {
        $site = new Site();

        // test empty
        $expected_result = NULL;
        $test = $site->get_current_code();
        $this->unit->run($test, $expected_result, 'Current Site Code should be NULL');

        $expected_result = array();
        $test = $site->get_available_site_codes();
        $this->unit->run($test, $expected_result, 'There should be no site code available');

        // add site
        $site->add_site('famous', array('bukurai.com', 'takada.com', 'pencuit.com'));
        $site->add_site('incognito');
        $site->add_site('oraono');

        $expected_result = array('famous', 'incognito', 'oraono');
        $test = $site->get_available_site_codes();
        $this->unit->run($test, $expected_result, 'Try add three site: famous, incognito, and oraono. Famous has 3 aliases: bukurai.com, takada.com, and pencuit.com');

        // there should be three alias for famous
        $expected_result = array('bukurai.com', 'takada.com', 'pencuit.com');
        $test = $site->get_aliases_by_code('famous');
        $this->unit->run($test, $expected_result, 'There should be three aliases of famous site: bukurai.com, takada.com, and pencuit.com');

        // delete oraono
        $site->delete_site('oraono');
        $expected_result = array('famous', 'incognito');
        $test = $site->get_available_site_codes();
        $this->unit->run($test, $expected_result, 'Delete oraono, available site codes are now: famous and incognito');

        // delete takada.com
        $site->delete_site_alias('famous', 'takada.com');
        $expected_result = array('bukurai.com', 'pencuit.com');
        $test = $site->get_aliases_by_code('famous');
        $this->unit->run($test, $expected_result, 'Delete takada.com from famous, available site alias for famous is bukurai.com and pencuit.com');

        // add alias
        $site->add_site_alias('incognito', 'ossass.com');
        $site->add_site_alias('incognito', 'uwewe.com');
        $expected_result = array('ossass.com', 'uwewe.com'); 
        $test = $site->get_aliases_by_code('incognito');
        $this->unit->run($test, $expected_result, 'Try add two aliases to incognito: ossass.com, uwewe.com. The two aliases should be there');

        // try to get code of ossass.com and pencuit.com
        $expected_result = 'incognito';
        $test = $site->get_code_by_alias('ossass.com');
        $this->unit->run($test, $expected_result, 'ossass.com is alias for incognito');

        $expected_result = 'famous';
        $test = $site->get_code_by_alias('pencuit.com');
        $this->unit->run($test, $expected_result, 'pencuit.com is alias for famous');

        $old_server_name = $_SERVER['SERVER_NAME'];

        // get current code with custom $_SERVER['SERVER_NAME']
        $_SERVER['SERVER_NAME'] = 'bukurai.com';
        $expected_result = 'famous';
        $test = $site->get_current_code();
        $this->unit->run($test, $expected_result, 'bukurai.com is famous');

        $expected_result = FALSE;
        $test = $site->is_main_site();
        $this->unit->run($test, $expected_result, 'bukurai.com is not main site');

        $_SERVER['SERVER_NAME'] = 'incognito.'.$old_server_name;
        $expected_result = 'incognito';
        $test = $site->get_current_code();
        $this->unit->run($test, $expected_result, 'incognito.'.$old_server_name.' is obviously incognito');

        $expected_result = FALSE;
        $test = $site->is_main_site();
        $this->unit->run($test, $expected_result, 'incognito is not main site');

        $_SERVER['SERVER_NAME'] = $old_server_name;
        $expected_result = NULL;
        $test = $site->get_current_code();
        $this->unit->run($test, $expected_result, 'Main site should not have current code');

        $expected_result = TRUE;
        $test = $site->is_main_site();
        $this->unit->run($test, $expected_result, 'Obviously main site is main site');

    }

}
