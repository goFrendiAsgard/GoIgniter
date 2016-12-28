<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Init_cms extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'hostnames' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('site');

        $this->db->insert('site', array('code' => 'coba1', 'hostnames' => ''));
        $this->db->insert('site', array('code' => 'coba2', 'hostnames' => 'coba.localtest.me ; coba3.localtest.me'));
    }

    public function down()
    {
        $this->dbforge->drop_table('site');
    }
}
