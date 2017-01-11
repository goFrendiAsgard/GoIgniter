<?php
namespace Modules\CMS;
use \Go_Migration;
use \Modules\Cms\Site_Model;

class CMS_Migration extends Go_Migration
{
    protected $current_site_id = NULL;

    public function __construct($config=array())
    {
        parent::__construct($config);

        $current_site = Site_Model::get_current_site();
        if($current_site != NULL)
        {
            $current_site_id = $current_site->id;
        }
    }

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
