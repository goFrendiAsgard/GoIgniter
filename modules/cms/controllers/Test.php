<?php
namespace Modules\Cms\Controllers;

use \Module_Migrator;
use \Site;
use \Modules\Cms\Test_Controller;
use \Modules\Cms\Mutator;
use \Modules\Cms\Models\Genesis;
use \Modules\Cms\Models\Test_Node;

class Test extends Test_Controller 
{

    function global_setup_and_tearDown()
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

        // delete files
        !file_exists(MODULEPATH.'cms/.mutation') || unlink(MODULEPATH.'cms/.mutation');
        !file_exists(MODULEPATH.'cms/.genesis') || unlink(MODULEPATH.'cms/.genesis');
        !file_exists(MODULEPATH.'cms/json/configuration.json') || unlink(MODULEPATH.'cms/json/configuration.json');
        !file_exists(MODULEPATH.'cms/json/routes.json') || unlink(MODULEPATH.'cms/json/routes.json');
        !file_exists(MODULEPATH.'cms/json/sites/routes-main.json') || unlink(MODULEPATH.'cms/json/routes-main.json');
        !file_exists(MODULEPATH.'cms/mutation_backup/config.php.bak') || unlink(MODULEPATH.'cms/mutation_backup/config.php.bak');
        !file_exists(MODULEPATH.'cms/mutation_backup/config.php.bak') || unlink(MODULEPATH.'cms/mutation_backup/config.php.bak');
        !file_exists(EXTCONFIGPATH.'config/config.php') || unlink(EXTCONFIGPATH.'config/config.php');
        !file_exists(EXTCONFIGPATH.'config/route.php') || unlink(EXTCONFIGPATH.'config/route.php');
    }

    function global_setup()
    {
        $test_route = json_encode(array(
            'nyan/(:any)' => 'cms/test/nyan/$1',
            'nyan' => 'cms/test/nyan'
        ));
        file_put_contents(MODULEPATH.'cms/json/routes.json', $test_route);
    }

    function global_tearDown()
    {
        // undo migration
        $module_migrator = new Module_Migrator();
        $module_migrator->migrate_all('current');
    }
    
    function nyan($nyan = 'nyan')
    {
        echo 'nyan nyan '.$nyan;
        if($this->input->get('a'))
        {
            echo ' '.$this->input->get('a');
        }
        if($this->input->get('b'))
        {
            echo ' '.$this->input->get('b');
        }
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

        $notes = 'You can pass user, password, and database get query to override database setting, i.e: ?user=root&password=&database=mydb.'. PHP_EOL .'By default this test use Mysql, user:root, password:toor, database:tests. '. PHP_EOL .'Please make sure that your testing database is empty';

        // Test $genesis->setup()
        $genesis->set_db_config('username', $db_user);
        $genesis->set_db_config('password', $db_password);
        $genesis->set_db_config('database', $db_database);

        $test = $genesis->setup();
        $expected_result = TRUE;
        $this->unit->run($test, $expected_result, 'genesis->setup() should yield TRUE', $notes);

        // Connection works
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

    function test_asset_url()
    {
        $expected_result = base_url('assets/modules/cms/jquery-3.1.1.min.js');
        $test = asset_url('cms/jquery-3.1.1.min.js');
        $this->unit->run($test, $expected_result, 'Asset URL of CMS\'s Jquery');

        $expected_result = base_url('assets/modules/cms/bootstrap-4.0.0-alpha.5-dist/css/bootstrap.min.css');
        $test = asset_url('cms/bootstrap-4.0.0-alpha.5-dist/css/bootstrap.min.css');
        $this->unit->run($test, $expected_result, 'Asset URL of CMS\'s Bootstrap');

        $old_server_name = $_SERVER['SERVER_NAME'];

        $_SERVER['SERVER_NAME'] = 'bukurai.com';

        $expected_result = base_url('assets/modules/cms/jquery-3.1.1.min.js');
        $test = asset_url('cms/jquery-3.1.1.min.js');
        $this->unit->run($test, $expected_result, 'Asset URL of bukurai.com\'s CMS\'s Jquery');

        $_SERVER['SERVER_NAME'] = 'incognito.'.$old_server_name;

        $expected_result = base_url('assets/modules/cms/jquery-3.1.1.min.js');
        $test = asset_url('cms/jquery-3.1.1.min.js');
        $this->unit->run($test, $expected_result, 'Asset URL of incognito\'s CMS\'s Jquery');

        $_SERVER['SERVER_NAME'] = $old_server_name;
    }

    function test_site_url()
    {
        $expected_result = base_url('index.php/cms');
        $test = site_url('cms');
        $this->unit->run($test, $expected_result, 'site URL of CMS');

        $old_server_name = $_SERVER['SERVER_NAME'];
        $this->load->config('config');
        $config = $this->config->config;
        $hostname = $config['hostname'];

        $_SERVER['SERVER_NAME'] = 'bukurai.com';

        $expected_result = str_replace('://'.$hostname, '://'.$_SERVER['SERVER_NAME'], base_url('index.php/cms'));
        $test = site_url('cms');
        $this->unit->run($test, $expected_result, 'site URL of bukurai.com\'s CMS');

        $_SERVER['SERVER_NAME'] = 'incognito.'.$old_server_name;

        $expected_result = str_replace('://'.$hostname, '://'.$_SERVER['SERVER_NAME'], base_url('index.php/cms'));
        $test = site_url('cms');
        $this->unit->run($test, $expected_result, 'site URL of incognito\'s CMS');

        $_SERVER['SERVER_NAME'] = $old_server_name;
    }


    function test_run_module_controller()
    {
        $expected_result = 'nyan nyan nyan tama';
        $test = run_module_controller('cms/test/nyan?a=tama', TRUE);
        $this->unit->run($test, $expected_result, 'Run Module Controller: cms/test/nyan?a=tama');

        $expected_result = 'nyan nyan gude tama';
        $test = run_module_controller('cms/test/nyan/gude?a=tama', TRUE);
        $this->unit->run($test, $expected_result, 'Run Module Controller: cms/test/nyan/gude?a=tama');

        $expected_result = 'nyan nyan nyan gude tama';
        $test = run_module_controller('cms/test/nyan/nyan?a=gude&b=tama', TRUE);
        $this->unit->run($test, $expected_result, 'Run Module Controller: cms/test/nyan?a=gude&b=tama');
    }

    function test_run_routed_module_url()
    {
        $expected_result = 'nyan nyan nyan';
        $test = run_routed_module_url('nyan', TRUE);
        $this->unit->run($test, $expected_result, 'Run Routed Module URL: nyan');

        $expected_result = 'nyan nyan nyan tama';
        $test = run_routed_module_url('cms/test/nyan?a=tama', TRUE);
        $this->unit->run($test, $expected_result, 'Run Routed Module URL: cms/test/nyan?a=tama');

        $expected_result = 'nyan nyan gude tama';
        $test = run_routed_module_url('nyan/gude?a=tama', TRUE);
        $this->unit->run($test, $expected_result, 'Run Routed Module URL: nyan/gude?a=tama');

        $expected_result = 'nyan nyan nyan gude tama';
        $test = run_routed_module_url('nyan/nyan?a=gude&b=tama', TRUE);
        $this->unit->run($test, $expected_result, 'Run Routed Module URL: nyan/nyan?a=gude&b=tama');
    }

    function test_orm()
    {
        $array = array(
            'code' => 'Ned Stark',
            'children' => array(
                array('code' => 'Robb Stark'),
                array('code' => 'Jon Snow'),
                array('code' => 'Sansa Stark'),
                array('code' => 'Arya Stark'),
                array('code' => 'Brandon Stark'),
            ), 
            'parent' => array('code' => 'Rickard Stark'),
        );

        // Try to create test_node with hybrid parameters (array & object)
        $obj = $array;
        $obj['children'][0] = new Test_Node($obj['children'][0]);
        $test_node = new Test_Node($obj);

        // test this test_node
        $expected_result = 'Ned Stark';
        $test = $test_node->code;
        $this->unit->run($test, $expected_result, 'Do $test_node = new Test_Node($obj); At this point, $test_node\'s code should be Ned Stark');

        $expected_result = 'Robb Stark';
        $test = $test_node->parent->children[0]->children[0]->code;
        $this->unit->run($test, $expected_result, 'The value of $test_node->parent->children[0]->children[0]->code should be "Robb Stark"');

        $expected_result = 'Rickard Stark';
        $test = $test_node->children[0]->parent->parent->code;
        $this->unit->run($test, $expected_result, 'The value of $test_node->children[0]->parent->parent->code should be "Rickard Stark"');

        // test children of test_node
        $expected_result = 5;
        $test = count($test_node->children);
        $this->unit->run($test, $expected_result, '$test_node should has 5 children');

        // test parent of test_node
        $expected_result = 'Rickard Stark';
        $test = $test_node->parent->code;
        $this->unit->run($test, $expected_result, '$test_node parent should be Rickard Stark');

        // test as_array
        $expected_result = $array;
        $expected_result['parent_id'] = NULL;
        //$expected_result['parent']['parent_id'] = NULL;
        for($i=0; $i<5; $i++)
        {
            $expected_result['children'][$i]['parent_id'] = NULL;
        }
        $test = $test_node->as_array();
        $this->unit->run($test, $expected_result, '$test_node->as_array() should return the correct array');

        // saving record
        $test_node->save();
        $expected_result = 7;
        $test = $this->db->count_all('test_node');
        $this->unit->run($test, $expected_result, '$test_node->save() should save 7 records');

        // primary keys should be set, foreign key should also be set
        $expected_result = 2;
        $test = $test_node->id;
        $this->unit->run($test, $expected_result, '$test_node->id should yield 2');
        $test = $test_node->children[0]->parent_id;
        $this->unit->run($test, $expected_result, '$test_node->children[0]->parent_id should yield 2');

        $expected_result = 1;
        $test = $test_node->parent->id;
        $this->unit->run($test, $expected_result, '$test_node->parent->id should yield 1');

        $test = $test_node->parent_id;
        $this->unit->run($test, $expected_result, '$test_node->parent_id should also yield 1');
        
        $expected_result = 3;
        $test = $test_node->children[0]->id;
        $this->unit->run($test, $expected_result, '$test_node->children[0]->id should yield 3');

        // created_at should be set, _deleted should be FALSE
        $expected_result = TRUE;
        $created_at = $test_node->created_at;
        $test_created_at = $created_at != NULL;
        $test_deleted = TRUE;
        $test_equality = TRUE;
        $all_nodes = array_merge(array($test_node, $test_node->parent), $test_node->children); 
        foreach($all_nodes as $node)
        {
            if($node->created_at == NULL)
            {
                $test_created_at = FALSE;
            }
            if($node->created_at != $created_at)
            {
                $test_equality = FALSE;
            }
            if($node->deleted == TRUE)
            {
                $test_deleted = FALSE;
            }
        }
        $this->unit->run($test_created_at, $expected_result, 'Every node\'s created_at should not be NULL');
        $this->unit->run($test_equality, $expected_result, 'Every node\'s created_at should be equal');
        $this->unit->run($test_deleted, $expected_result, 'Every node\'s deleted should not be FALSE');

        // delete
        $test_node->children[0]->delete();

        $expected_result = TRUE;
        $test = $test_node->children[0]->deleted;
        $this->unit->run($test, $expected_result, 'node Robb deleted should be TRUE');
        
        $expected_result = TRUE;
        $test = $test_node->children[0]->deleted_at != NULL;
        $this->unit->run($test, $expected_result, 'node Robb deleted_at should not be NULL');

        // purge
        $test_node->children[0]->purge();

        $expected_result = 6;
        $test = $this->db->count_all('test_node');
        $this->unit->run($test, $expected_result, 'node Robb _purged, only 6 record available in the table now');


        // test find_by_id
        $rickard = Test_Node::find_by_id(1);
        $expected_result = 'Rickard Stark';
        $test = $rickard->code;
        $this->unit->run($test, $expected_result, 'Test_Node::find_by_id(1); should give you Rickard Stark');

        // test find_all
        $node_list = Test_Node::find_all();
        $expected_result = 6;
        $test = count($node_list);
        $this->unit->run($test, $expected_result, 'Test_Node::find_all(); should give you 6 records');

        // ORM is cool, but I want to try query
        $node_list = Test_Node::find_by_query($this->db->select('*')->from('test_node')->like('code', 'snow'));
        $expected_result = 'Jon Snow';
        $test = $node_list[0]->code;
        $this->unit->run($test, $expected_result, 'Test_Node::find_by_query($this->db->select(\'*\')->from(\'test_node\')->like(\'code\', \'snow\')); should give you Jon Snow');
    }

}
