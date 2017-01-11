<?php defined('BASEPATH') OR exit('No direct script access allowed');
use \Modules\Cms\CMS_Migration;

class Migration_Init_data extends CMS_Migration {

    public function up()
    {
        // this is for testing
        $this->current_site_db_insert('test_node', array('code' => 'gilgamesh'));

        $this->current_site_db_insert('cms_config', array('key' => 'test', 'value' => 'test'));
    }

    public function down()
    {
        $this->current_site_db_delete('cms_config', array('key' => 'test'));

        // this is for testing
        $this->current_site_db_delete('test_node', array('code' => 'gilgamesh'));
    }
}
