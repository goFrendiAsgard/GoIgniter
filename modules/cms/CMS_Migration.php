<?php
namespace Modules\CMS;
use \Go_Migration;

class CMS_Migration extends Go_Migration
{
    public function add_cms_general_default_fields()
    {
        parent::add_default_fields();
        $this->dbforge->add_field(array(
            'created_by' => array(
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'updated_by' => array(
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'deleted_by' => array(
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
        ));
    }

    public function add_cms_default_fields()
    {
        $this->add_cms_general_default_fields();
        $this->dbforge->add_field(array(
            'site_id' => array(
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
        ));

    }
}
