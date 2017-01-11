<?php defined('BASEPATH') OR exit('No direct script access allowed');
use \Modules\Cms\CMS_Migration;

class Migration_Init_cms extends CMS_Migration {

    public function up()
    {
        $this->db->insert('cms_config', array('site_id' => $this->site_id, 'key' => 'test', 'value' => 'test'));
    }

    public function down()
    {
        $this->db->delete('cms_config', array('site_id' => $this->site_id, 'key' => 'test'));
    }
}
