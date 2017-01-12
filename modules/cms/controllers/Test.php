<?php
namespace Modules\Cms\Controllers;

///////////////////////////////////////////////////////////////////////////
//
//  Imports
//
///////////////////////////////////////////////////////////////////////////

use \Site;
use \Go_Migration;
use \Module_Migrator;
use \Modules\Cms\Mutator;
use \Modules\Cms\Site_Model;
use \Modules\Cms\User_Model;
use \Modules\Cms\Test_Controller;
use \Modules\Cms\CMS_Module_Migrator;
use \Modules\Cms\Models\Genesis;

///////////////////////////////////////////////////////////////////////////
//
//  Classes
//
///////////////////////////////////////////////////////////////////////////

class Test_Node extends \Go_Model
{
}

class Test_Node_Marriage extends \Go_Model
{
    protected $_table = 'test_node_marriage';
    protected $_columns = ['husband_id', 'wife_id'];

    protected $_parents = array(
        'husband' => array(
            'model' => 'Modules\Cms\Controllers\Full_Test_Node',
            'foreign_key' => 'husband_id',
        ),
        'wife' => array(
            'model' => 'Modules\Cms\Controllers\Full_Test_Node',
            'foreign_key' => 'wife_id',
        ),
    );

}

class Full_Test_Node extends \Go_Model
{
    protected $_table = 'test_node';
    protected $_id = 'id';
    protected $_created_at = 'created_at';
    protected $_updated_at = 'updated_at';
    protected $_deleted_at = 'deleted_at';
    protected $_deleted = 'deleted';
    protected $_columns = ['code', 'parent_id', 'child_count'];
    protected $_unique_columns = ['code'];

    protected $code = 'default';

    protected $_children = array(
        'children' => array(
            'model' => 'Modules\Cms\Controllers\Full_Test_Node',
            'foreign_key' => 'parent_id',
            'on_delete' => 'set_null', // restrict, cascade, set_null
            'on_purge' => 'set_null', // restric, cascade, set_null
        ),
    );

    protected $_parents = array(
        'parent' => array(
            'model' => 'Modules\Cms\Controllers\Full_Test_Node',
            'foreign_key' => 'parent_id',
        ),
    );

    protected $_many_to_many = array(
        'wife' => array(
            'pivot_model' => 'Modules\Cms\Controllers\Test_Node_Marriage',
            'backref_relation' => 'husband',
            'relation' => 'wife',
            'on_delete' => 'set_null',
        ),
        'husband' => array(
            'pivot_model' => 'Modules\Cms\Controllers\Test_Node_Marriage',
            'backref_relation' => 'wife',
            'relation' => 'husband',
            'on_delete' => 'set_null',
        )
    );

    protected function before_save(&$success, &$error_message)
    {
        $this->child_count = count($this->children);
    }

}


///////////////////////////////////////////////////////////////////////////
//
//  Tester
//
///////////////////////////////////////////////////////////////////////////

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

        // Test DB Migration
        $migrator->migrate('cms');
        $errors = $migrator->get_error();

        $test = $errors['cms'];
        $expected_result = '';
        $this->unit->run($test, $expected_result, '$migrate->migrate("cms")');
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
        $expected_result = base_url('assets/modules/cms/bootstrap-4.0.0-alpha.5-dist/css/bootstrap.min.css');
        $test = asset_url('cms/bootstrap-4.0.0-alpha.5-dist/css/bootstrap.min.css');
        $this->unit->run($test, $expected_result, 'Asset URL of CMS\'s Bootstrap');

        $expected_result = base_url('assets/modules/cms/jquery-3.1.1.min.js');
        $test = asset_url('cms/jquery-3.1.1.min.js');
        $this->unit->run($test, $expected_result, 'Asset URL of CMS\'s Jquery');

        $old_server_name = $_SERVER['SERVER_NAME'];

        $_SERVER['SERVER_NAME'] = 'bukurai.com';

        $test = asset_url('cms/jquery-3.1.1.min.js');
        $this->unit->run($test, $expected_result, 'Asset URL of bukurai.com\'s CMS\'s Jquery');

        $_SERVER['SERVER_NAME'] = 'incognito.'.$old_server_name;

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

        $expected_result = base_url('index.php/cms');
        $test = site_url('cms');
        $this->unit->run($test, $expected_result, 'site URL of evil.com (host header injection). This should be no evil.com there');

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

    function test_full_orm()
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
            'parent' => array('code' => 'Rick Stark'),
        );

        // Try to create test_node with hybrid parameters (array & object)
        $obj = $array;
        $obj['children'][0] = new Full_Test_Node($obj['children'][0]);
        $test_node = new Full_Test_Node($obj);

        $jon_snow = $test_node->children[0];
        $jon_snow->parent->parent->code = 'Rickard Stark';

        // test this test_node
        $expected_result = 'Ned Stark';
        $test = $test_node->code;
        $this->unit->run($test, $expected_result, 'Do $test_node = new Full_Test_Node($obj); At this point, $test_node\'s code should be Ned Stark');

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
        $expected_result['parent']['code'] = 'Rickard Stark';
        for($i=0; $i<5; $i++)
        {
            $expected_result['children'][$i]['parent_id'] = NULL;
        }
        $expected_result['wife'.md5('wife')] = array();
        $expected_result['husband'.md5('husband')] = array();
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
        $this->unit->run($test, $expected_result, '$test_node->parent->id should also yield 1');
        
        $expected_result = 3;
        $test = $test_node->children[0]->id;
        $this->unit->run($test, $expected_result, '$test_node->children[0]->id should yield 3');

        // created_at should be set, _deleted should be FALSE
        $expected_result = TRUE;
        $created_at = $test_node->created_at;
        $test_created_at = $created_at != NULL;
        $test_deleted = TRUE;
        $all_nodes = array_merge(array($test_node, $test_node->parent), $test_node->children); 
        foreach($all_nodes as $node)
        {
            if($node->created_at == NULL)
            {
                $test_created_at = FALSE;
            }
            if($node->deleted == TRUE)
            {
                $test_deleted = FALSE;
            }
        }
        $this->unit->run($test_created_at, $expected_result, 'Every node\'s created_at should not be NULL');
        $this->unit->run($test_deleted, $expected_result, 'Every node\'s deleted should not be FALSE');

        // delete
        $test_node->children[0]->delete();

        $expected_result = 'Jon Snow';
        $test = $test_node->children[0]->code;
        $this->unit->run($test, $expected_result, 'Robb has been deleted, the first child of Ned should be Jon Snow');

        $robb = Full_Test_Node::find_by_id(3);

        $expected_result = TRUE;
        $test = $robb->deleted;
        $this->unit->run($test, $expected_result, 'Robb\'s deleted should be TRUE');
        
        $expected_result = TRUE;
        $test = $robb->deleted_at != NULL;
        $this->unit->run($test, $expected_result, 'Robb\'s deleted_at should not be NULL');

        $expected_result = 7;
        $test = $this->db->count_all('test_node');
        $this->unit->run($test, $expected_result, 'node Robb was deleted but not purged, there should be 7 record in the table');

        // purge
        $robb->purge();

        $expected_result = 6;
        $test = $this->db->count_all('test_node');
        $this->unit->run($test, $expected_result, 'node Robb is purged, only 6 record available in the table now');

        // test find_by_id
        $ned = Full_Test_Node::find_by_id(2);
        $expected_result = 'Ned Stark';
        $test = $ned->code;
        $this->unit->run($test, $expected_result, '$ned = Full_Test_Node::find_by_id(2); should give you Ned Stark');

        // get parent
        $expected_result = 'Rickard Stark';
        $test = $ned->parent->code;
        $this->unit->run($test, $expected_result, '$ned->parent->code; should give you Rickard Stark');

        // get children
        $expected_result = 4;
        $test = count($ned->children);
        $this->unit->run($test, $expected_result, 'count($ned->children); should give you 4');

        // try to get and update jon snow
        $jon_snow = $ned->children[0];
        $jon_snow->code = 'Lord Commander Jon Snow';
        $jon_snow->save();

        $node_list = Full_Test_Node::find_where('code', 'Lord Commander Jon Snow');
        $expected_result = 'Lord Commander Jon Snow';
        $test = $node_list[0]->code;
        $this->unit->run($test, $expected_result, 'Updating Jon Snow into Lord Commander Jon Snow');

        // test find_all
        $node_list = Full_Test_Node::find_all();
        $expected_result = 6;
        $test = count($node_list);
        $this->unit->run($test, $expected_result, 'Full_Test_Node::find_all(); should give you 6 records');

        // ORM is cool, but I want to try query
        $node_list = Full_Test_Node::find_by_query($this->db->select('*')->from('test_node')->like('code', 'snow'));
        $expected_result = 'Lord Commander Jon Snow';
        $test = $node_list[0]->code;
        $this->unit->run($test, $expected_result, 'Full_Test_Node::find_by_query($this->db->select(\'*\')->from(\'test_node\')->like(\'code\', \'snow\')); should give you Jon Snow');

        $node_list = Full_Test_Node::find_by_query($this->db->query("SELECT * FROM go_test_node WHERE code LIKE '%snow%'"));
        $expected_result = 'Lord Commander Jon Snow';
        $test = $node_list[0]->code;
        $this->unit->run($test, $expected_result, 'Full_Test_Node::find_by_query($this->db->query("SELECT * FROM go_test_node WHERE code LIKE \'%snow%\'"))');
        
        $node_list = Full_Test_Node::find_by_query("SELECT * FROM go_test_node WHERE code LIKE '%snow%'");
        $expected_result = 'Lord Commander Jon Snow';
        $test = $node_list[0]->code;
        $this->unit->run($test, $expected_result, 'Full_Test_Node::find_by_query("SELECT * FROM go_test_node WHERE code LIKE \'%snow%\'")');

        // Test add grand parent
        $ned = Full_Test_Node::find_by_id(2);
        $ned->parent->parent = new Test_Node(array('code'=>'Edwyle Stark'));
        $ned->save();

        $test = $this->db->count_all('test_node');
        $expected_result = 7;
        $this->unit->run($test, $expected_result, 'add Edwyle Stark');

        // Test add duplicate unique code
        $other_ned = new Full_Test_Node(array('code' => 'Ned Stark'));
        $save_result = $other_ned->save();
        $notes = var_export($save_result, TRUE);

        $expected_result = FALSE;
        $test = $save_result['success'];
        $this->unit->run($test, $expected_result, '$other_ned->save(); should return array which success key if FALSE', $notes);
    }


    function test_minimal_orm()
    {
        $CI =& get_instance();
        $db =& $CI->db;
        $test_node = Test_Node::find_by_id(1);

        $expected_result = 'Rickard Stark';
        $test = $test_node->code;
        $notes = var_export($db->get('test_node')->result(), TRUE);
        $this->unit->run($test, $expected_result, 'Test_Node::find_by_id(1) should give Rickard Stark', $notes);

    }

    function test_orm_many_to_many()
    {
        $pandu = new Full_Test_node(array(
            'code' => 'pandu',
            'wife' => array(
                array('code' => 'kunthi'),
                array('code' => 'madri'),
            ),
        ));
        $kunthi = $pandu->wife[0];
        $madri = $pandu->wife[1];

        $expected_result = 'kunthi';
        $test = $pandu->wife[0]->code;
        $this->unit->run($test, $expected_result, 'First wife of pandu should be kunthi');

        $expected_result = 'madri';
        $test = $pandu->wife[1]->code;
        $this->unit->run($test, $expected_result, 'Second wife of pandu should be madri');

        $expected_result = 'pandu';
        $test = $kunthi->husband[0]->code;
        $this->unit->run($test, $expected_result, 'First husband of kunthi should be pandu');

        $expected_result = 'pandu';
        $test = $madri->husband[0]->code;
        $this->unit->run($test, $expected_result, 'First husband of madri should be pandu');

        $pandu->save();
    }

    function test_orm_child_manipulation()
    {
        $node = new Full_Test_Node(array('code' => 'adam'));
        $child_one = new Full_Test_Node(array('code' => 'cain'));
        $child_two = new Full_Test_Node(array('code' => 'abel'));
        $child_three = new Full_Test_Node(array('code' => 'set'));

        $node->add_children($child_one);
        $node->add_children($child_two);
        $node->remove_children($child_one); // child one removed while node is not saved yet, we should save it later if we want it to be available in the database

        $node->save();
        $child_one->save();

        // child two's parent should be "node"
        $expected_result = $node->id;
        $row = $this->db->select('parent_id')->from('test_node')->where('id', $child_two->id)->get()->row();
        $test = $row->parent_id;
        $this->unit->run($test, $expected_result, 'child two\'s parent should be node. So the id must be same');

        // child one's parent should be null
        $expected_result = NULL;
        $row = $this->db->select('parent_id')->from('test_node')->where('id', $child_one->id)->get()->row();
        $test = $row->parent_id;
        $this->unit->run($test, $expected_result, 'child two\'s parent should be null');

        $node->children = array($child_three);
        $node->save();

        // child three's parent should now be node
        $expected_result = $node->id;
        $row = $this->db->select('parent_id')->from('test_node')->where('id', $child_three->id)->get()->row();
        $test = $row->parent_id;
        $this->unit->run($test, $expected_result, 'child three\'s parent should be node');

        // child two's parent should now be null
        $expected_result = NULL;
        $row = $this->db->select('parent_id')->from('test_node')->where('id', $child_two->id)->get()->row();
        $test = $row->parent_id;
        $this->unit->run($test, $expected_result, 'child two\'s parent should be null');

    }

    function test_orm_circular_reference()
    {
        $CI =& get_instance();
        $db =& $CI->db;

        // create "god"
        $god = new Full_Test_Node(array('code' => 'god'));
        $god->save();

        // now, who is the parent of "god"? ah of course, "god" himself :v
        // so, try circular reference
        $god->parent = $god;
        $god->save();

        // god should be exists in the database by now
        $god_in_db = $db->select('*')->from('test_node')->where('code', 'god')->get()->row();
        $expected_result = TRUE;
        $test = $god_in_db !== NULL;
        $notes = var_export($god_in_db, TRUE);
        $this->unit->run($test, $expected_result, 'Perform $god->save(); God should be exists in database', $notes);

        // god's parent should be god. Look at the record from db to make sure
        $expected_result = 'god';
        $test = $god->parent->code;
        $this->unit->run($test, $expected_result, 'Since $god->parent is itself, then $god->parent->code should be "god"');

        // god's child should also be god.
        $expected_result = 'god';
        $test = $god->children[0]->code;
        $this->unit->run($test, $expected_result, 'Since $god->children[0] is itself, then $god->children[0]->code should also be "god"');
    }

    function test_orm_circular_reference_again()
    {
        $CI =& get_instance();
        $db =& $CI->db;

        // create "other_god"
        $other_god = new Full_Test_Node(array('code' => 'other_god'));
        $other_god->parent = $other_god;
        $other_god->save();


        // god should be exists in the database by now
        $other_god_in_db = $db->select('*')->from('test_node')->where('code', 'other_god')->get()->row();
        $expected_result = TRUE;
        $test = $other_god_in_db !== NULL;
        $notes = var_export($other_god_in_db, TRUE);
        $this->unit->run($test, $expected_result, 'Perform $other_god->save(); God should be exists in database', $notes);

        // other_god's parent should be other_god. Look at the record from db to make sure
        $expected_result = 'other_god';
        $test = $other_god->parent->code;
        $this->unit->run($test, $expected_result, 'This test is different from the first, since we assign $other_god->parent to itself even before save it to the database first. And since $other_god->parent is itself, then $other_god->parent->code should be "other_god"');

        // other_god's child should also be other_god.
        $expected_result = 'other_god';
        $test = $other_god->children[0]->code;
        $this->unit->run($test, $expected_result, 'Since $other_god->children[0] is itself, then $other_god->children[0]->code should also be "other_god"');
    }


    function test_go_migration_alias()
    {
        $go_migration = new Go_Migration();

        $expected_result = array(
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => FALSE,
        );
        $test = $go_migration->type_varchar_255;
        $this->unit->run($test, $expected_result, '$go_migration->type_varchar_255 should return the correct type');

        $expected_result = array(
            'type' => 'BIGINT',
            'constraint' => 20,
            'null' => TRUE,
        );
        $test = $go_migration->TYPE_BIGINT_20_NULL;
        $this->unit->run($test, $expected_result, '$go_migration->TYPE_BIGINT_20_NULL should return the correct type');

        $expected_result = array(
            'type' => 'BIGINT',
            'constraint' => 20,
            'unsigned' => TRUE,
            'null' => TRUE,
        );
        $test = $go_migration->TYPE_FOREIGN_KEY;
        $this->unit->run($test, $expected_result, '$go_migration->TYPE_FOREIGN_KEY should return the correct type');

        $test = $go_migration->TYPE_FOREIGNKEY;
        $this->unit->run($test, $expected_result, '$go_migration->TYPE_FOREIGNKEY should return the correct type');

        $expected_result = array(
            'type' => 'BIGINT',
            'constraint' => 20,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        );
        $test = $go_migration->TYPE_PRIMARY_KEY;
        $this->unit->run($test, $expected_result, '$go_migration->TYPE_PRIMARY_KEY should return the correct type');

        $test = $go_migration->TYPE_PRIMARYKEY;
        $this->unit->run($test, $expected_result, '$go_migration->TYPE_PRIMARYKEY should return the correct type');
    }

    function test_user_model()
    {
        // test create user

        $admin = new User_Model(array(
            'user_name' => 'admin', 
            'email' => 'admin@email.com',
            'password' => 'password',
        ));
        $admin->save();

        $test = $this->db->count_all('cms_user');
        $expected_result = 1;
        $this->unit->run($test, $expected_result, 'User \'admin\' created, there should be one user in the table');

        // test login
        User_Model::login('admin', 'password');
        $test = User_Model::get_current_user()->user_name;
        $expected_result = 'admin';
        $this->unit->run($test, $expected_result, 'Right now, the current user should be admin');

        // test logout 
        User_Model::logout();
        $test = User_Model::get_current_user();
        $expected_result = NULL;
        $this->unit->run($test, $expected_result, 'Logout, current user should be null');

        // test login again, wrongly
        User_Model::login('admin', 'wrongpassword');
        $test = User_Model::get_current_user();
        $expected_result = NULL;
        $this->unit->run($test, $expected_result, 'Login with the wrong password, current user should be null');

        // test login again, correctly
        User_Model::login('admin', 'password');
        $test = User_Model::get_current_user()->user_name;
        $expected_result = 'admin';
        $this->unit->run($test, $expected_result, 'Login with the right password, right now, the current user should be admin');

        $employee = new User_Model(array(
            'user_name' => 'employee', 
            'email' => 'employee@email.com',
        ));
        $employee->password = 'employee';

        $employee->save();
        $test = $this->db->count_all('cms_user');
        $expected_result = 2;
        $this->unit->run($test, $expected_result, 'User \'employee\' created, there should be two users in the table');

        $test = $employee->creator->user_name;
        $expected_result = 'admin';
        $this->unit->run($test, $expected_result, 'Employee\'s creator should be admin');

    }

    function test_site_model()
    {
        // delete all site
        $core_site = new Site();
        foreach($core_site->get_available_site_codes() as $code)
        {
            $core_site->delete_site($code);
        }

        // try use site_model
        $site = new Site_Model(array(
            'code' => 'alpha',
            'aliases' => array(
                array('alias' => 'alpha.com'),
                array('alias' => 'aliph.com'),
            )
        ));
        $site->save();

        $test = $this->db->count_all('cms_site');
        $expected_result = 1;
        $this->unit->run($test, $expected_result, 'Site alpha has been added');

        $test = $this->db->count_all('cms_site_alias');
        $expected_result = 2;
        $this->unit->run($test, $expected_result, 'Alias alpha and aliph has been added');

        $test = $core_site->get_aliases_by_code('alpha');
        $expected_result = array('alpha.com', 'aliph.com');
        $this->unit->run($test, $expected_result, 'Site alpha should have two aliases, alpha.com, aliph.com');

        $old_server_name = $_SERVER['SERVER_NAME'];
        $_SERVER['SERVER_NAME'] = 'alpha.com';

        // test alpha's code
        $expected_result = 'alpha';
        $test = $core_site->get_current_code();
        $this->unit->run($test, $expected_result, 'Change server name to "alpha.com", site current code should be "alpha"');

        // test alpha's id
        $expected_result = 1;
        $test = Site_Model::get_current_site()->id;
        $this->unit->run($test, $expected_result, 'Site current id should be 1');

        $_SERVER['SERVER_NAME'] = $old_server_name;
    }

    function test_cms_module_migrator()
    {
        $this->load->config('migration');
        $config = $this->config->config;
        $migration_table = array_key_exists('migration.migration_table', $config)? $config['migration.migration_table'] : $config['migration_table'];

        // prepare migration on alpha site
        $old_server_name = $_SERVER['SERVER_NAME'];
        $_SERVER['SERVER_NAME'] = 'alpha.com';
        $cms_module_migrator =  new CMS_Module_Migrator();
        $cms_module_migrator->migrate_all();

        // test version
        $expected_result = TRUE;
        $row = $this->db->select('version')->from($migration_table.'_cms_site_1')->get()->row();
        $test = $row->version > 0;
        $notes = 'Current version is now '.$row->version;
        $this->unit->run($test, $expected_result, 'After migration of alpha site, the version should be greater than 0', $notes);

        // test existance of gilgamesh
        $expected_result = TRUE;
        $row = $this->db->select('*')->from('test_node')->where('site_id', 1)->where('code', 'gilgamesh')->get()->row();
        $test = $row != NULL;
        $notes = var_export($row, TRUE);
        $this->unit->run($test, $expected_result, 'After migration of alpha site, we should have gilgamesh with site_id 1', $notes);

        // back to zero
        $cms_module_migrator->migrate_all('current');
        $_SERVER['SERVER_NAME'] = $old_server_name;

        // prepare migration on main site
        $cms_module_migrator =  new CMS_Module_Migrator();
        $cms_module_migrator->migrate_all();

        // test version
        $expected_result = TRUE;
        $row = $this->db->select('version')->from($migration_table.'_cms_site_main')->get()->row();
        $test = $row->version > 0;
        $notes = 'Current version is now '.$row->version;
        $this->unit->run($test, $expected_result, 'After migration of main site, the version should be greater than 0', $notes);

        // test existance of gilgamesh
        $expected_result = TRUE;
        $row = $this->db->select('*')->from('test_node')->where('site_id', NULL)->where('code', 'gilgamesh')->get()->row();
        $test = $row != NULL;
        $notes = var_export($row, TRUE);
        $this->unit->run($test, $expected_result, 'After migration of main site, we should have gilgamesh with site_id NULL', $notes);

        // back to zero
        $cms_module_migrator->migrate_all('current');
    }

}
