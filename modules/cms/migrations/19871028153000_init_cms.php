<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Init_cms extends CI_Migration {

    public function up()
    {
        ////////////////////////////////////////////////////////////
        // Create module
        ////////////////////////////////////////////////////////////
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('cms_module');

        ////////////////////////////////////////////////////////////
        // Create site
        ////////////////////////////////////////////////////////////
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('cms_site');

        ////////////////////////////////////////////////////////////
        // Create site_alias
        ////////////////////////////////////////////////////////////
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
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
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('cms_site_alias');

        ////////////////////////////////////////////////////////////
        // Create site_module
        ////////////////////////////////////////////////////////////
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'site_id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
            ),
            'site_id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('cms_site_module');

        ////////////////////////////////////////////////////////////
        // Create config
        ////////////////////////////////////////////////////////////
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
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
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('cms_config');

        ////////////////////////////////////////////////////////////
        // Create group
        ////////////////////////////////////////////////////////////
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
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
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('cms_group');

        ////////////////////////////////////////////////////////////
        // Create user
        ////////////////////////////////////////////////////////////
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
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
        $this->dbforge->add_key('id', TRUE);
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
    }
}
