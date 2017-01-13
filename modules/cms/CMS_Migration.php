<?php
namespace Modules\CMS;
use \Go_Migration;
use \Modules\Cms\Models\Site_Model;

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

    public function get_current_site_id()
    {
        $current_site_id = NULL;
        $current_site = Site_Model::get_current_site();
        if($current_site != NULL)
        {
            $current_site_id = $current_site->id;
        }
        return $current_site_id;
    }

    public function current_site_db_insert($table = '', $set = NULL, $escape = NULL)
    {
        if(is_array($set))
        {
            $set['site_id'] = $this->get_current_site_id();
        }
        return $this->db->insert($table, $set, $escape);
    }

    public function current_site_db_update($table = '', $set = NULL, $where = NULL, $limit = NULL)
    {
        if(is_array($where))
        {
            $where['site_id'] = $this->get_current_site_id();
        }
        return $this->db->update($table, $set, $where, $limit);
    }

    public function current_site_db_delete($table = '', $where = '', $limit = NULL, $reset_data = TRUE)
    {
        if(is_array($where))
        {
            $where['site_id'] = $this->get_current_site_id();
        }
        return $this->db->delete($table, $where, $limit, $reset_data);
    }

}
