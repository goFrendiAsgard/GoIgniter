<?php defined('BASEPATH') OR exit('No direct script access allowed');
use \Modules\Cms\CMS_Migration;

class Migration_Init_cms extends CMS_Migration {

    public function up()
    {
        // Create test_node
        $this->add_default_fields();
        $this->add_field(array(
            'code'          => $this->TYPE_VARCHAR_255,
            'parent_id'     => $this->TYPE_FOREIGN_KEY,
            'child_count'   => $this->TYPE_INT_20_UNSIGNED_NULL,
        ));
        $this->create_table('test_node');

        // Create module
        $this->add_cms_default_fields();
        $this->add_field(array(
            'code'      => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_module');

        // Create site
        $this->add_cms_default_fields();
        $this->add_field(array(
            'code'      => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_site');

        // Create site_alias
        $this->add_cms_default_fields();
        $this->add_field(array(
            'alias'     => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_site_alias');

        // Create site_module
        $this->add_cms_general_default_fields();
        $this->add_field(array(
            'module_id' => $this->TYPE_FOREIGN_KEY,
        ));
        $this->create_table('cms_site_module');

        // Create config
        $this->add_cms_default_fields();
        $this->add_field(array(
            'module_id'     => $this->TYPE_FOREIGN_KEY,
            'type'          => $this->TYPE_VARCHAR_255,
            'key'           => $this->TYPE_VARCHAR_255,
            'value'         => $this->TYPE_VARCHAR_255,
            'json_options'  => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_config');

        // Create group
        $this->add_cms_default_fields();
        $this->add_field(array(
            'module_id'     => $this->TYPE_FOREIGN_KEY,
            'group_name'    => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_group');

        // Create user
        $this->add_cms_general_default_fields();
        $this->add_field(array(
            'user_name'         => $this->TYPE_VARCHAR_255,
            'hashed_password'   => $this->TYPE_VARCHAR_255,
            'email'             => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_user');

    }

    public function down()
    {
        $this->drop_table('cms_user');
        $this->drop_table('cms_group');
        $this->drop_table('cms_config');
        $this->drop_table('cms_site_module');
        $this->drop_table('cms_site_alias');
        $this->drop_table('cms_site');
        $this->drop_table('cms_module');
        $this->drop_table('test_node');
    }
}
