<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Init_cms extends Go_Migration {

    public function up()
    {
        ////////////////////////////////////////////////////////////
        // Create test_node
        ////////////////////////////////////////////////////////////
        $this->add_default_fields();
        $this->dbforge->add_field(array(
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'parent_id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'child_count' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),

        ));
        $this->dbforge->create_table('test_node');

        ////////////////////////////////////////////////////////////
        // Create module
        ////////////////////////////////////////////////////////////
        $this->add_default_fields();
        $this->dbforge->add_field(array(
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        ));
        $this->dbforge->create_table('cms_module');

        ////////////////////////////////////////////////////////////
        // Create site
        ////////////////////////////////////////////////////////////
        $this->add_default_fields();
        $this->dbforge->add_field(array(
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        ));
        $this->dbforge->create_table('cms_site');

        ////////////////////////////////////////////////////////////
        // Create site_alias
        ////////////////////////////////////////////////////////////
        $this->add_default_fields();
        $this->dbforge->add_field(array(
            'site_id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
            ),
            'alias' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        ));
        $this->dbforge->create_table('cms_site_alias');

        ////////////////////////////////////////////////////////////
        // Create site_module
        ////////////////////////////////////////////////////////////
        $this->add_default_fields();
        $this->dbforge->add_field(array(
            'site_id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
            ),
            'module_id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
            ),
        ));
        $this->dbforge->create_table('cms_site_module');

        ////////////////////////////////////////////////////////////
        // Create config
        ////////////////////////////////////////////////////////////
        $this->add_default_fields();
        $this->dbforge->add_field(array(
            'site_id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'module_id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'key' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'value' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'json_options' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        ));
        $this->dbforge->create_table('cms_config');

        ////////////////////////////////////////////////////////////
        // Create group
        ////////////////////////////////////////////////////////////
        $this->add_default_fields();
        $this->dbforge->add_field(array(
            'site_id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'module_id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'group_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        ));
        $this->dbforge->create_table('cms_group');

        ////////////////////////////////////////////////////////////
        // Create user
        ////////////////////////////////////////////////////////////
        $this->add_default_fields();
        $this->dbforge->add_field(array(
            'site_id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'user_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'hashed_password' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ),
        ));
        $this->dbforge->create_table('cms_user');

    }

    public function down()
    {
        $this->dbforge->drop_table('cms_user');
        $this->dbforge->drop_table('cms_group');
        $this->dbforge->drop_table('cms_config');
        $this->dbforge->drop_table('cms_site_module');
        $this->dbforge->drop_table('cms_site_alias');
        $this->dbforge->drop_table('cms_site');
        $this->dbforge->drop_table('cms_module');
        $this->dbforge->drop_table('test_node');
    }
}
