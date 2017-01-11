<?php defined('BASEPATH') OR exit('No direct script access allowed');
use \Modules\Cms\CMS_Migration;

class Migration_Init_cms extends CMS_Migration {

    public function up()
    {
        // test_node
        $this->add_default_fields();
        $this->add_field(array(
            'code'          => $this->TYPE_VARCHAR_255,
            'parent_id'     => $this->TYPE_FOREIGN_KEY,
            'child_count'   => $this->TYPE_INT_20_UNSIGNED_NULL,
        ));
        $this->create_table('test_node');

        // module
        $this->add_cms_default_fields();
        $this->add_field(array(
            'code'      => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_module');

        // site
        $this->add_cms_default_fields();
        $this->add_field(array(
            'code'      => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_site');

        // site_alias
        $this->add_cms_default_fields();
        $this->add_field(array(
            'alias'     => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_site_alias');

        // site_module
        $this->add_cms_general_default_fields();
        $this->add_field(array(
            'module_id' => $this->TYPE_FOREIGN_KEY,
        ));
        $this->create_table('cms_site_module');

        // config
        $this->add_cms_default_fields();
        $this->add_field(array(
            'module_id'     => $this->TYPE_FOREIGN_KEY,
            'type'          => $this->TYPE_VARCHAR_255_NULL,
            'key'           => $this->TYPE_VARCHAR_255_NULL,
            'value'         => $this->TYPE_VARCHAR_255_NULL,
            'json_options'  => $this->TYPE_VARCHAR_255_NULL,
        ));
        $this->create_table('cms_config');

        // group
        $this->add_cms_default_fields();
        $this->add_field(array(
            'module_id'     => $this->TYPE_FOREIGN_KEY,
            'group_name'    => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_group');

        // user
        $this->add_cms_general_default_fields();
        $this->add_field(array(
            'user_name'         => $this->TYPE_VARCHAR_255,
            'email'             => $this->TYPE_VARCHAR_255_NULL,
            'api_session_code'  => $this->TYPE_VARCHAR_255_NULL,
            'hashed_password'   => $this->TYPE_VARCHAR_255_NULL,
            'first_name'        => $this->TYPE_VARCHAR_255_NULL,
            'last_name'         => $this->TYPE_VARCHAR_255_NULL,
            'birthday'          => $this->TYPE_DATETIME_NULL,
            'profile_picture'   => $this->TYPE_TEXT_NULL,
            'description'       => $this->TYPE_TEXT_NULL,
            'last_login'        => $this->TYPE_DATETIME_NULL,
            'active'            => $this->TYPE_TINYINT_UNSIGNED_10,
        ));
        $this->create_table('cms_user');

        // user_group
        $this->add_cms_default_fields();
        $this->add_field(array(
            'user_id'   => $this->TYPE_FOREIGN_KEY,
            'group_id'  => $this->TYPE_FOREIGN_KEY,
        ));
        $this->create_table('cms_user_group');

        // layout
        $this->add_cms_default_fields();
        $this->add_field(array(
            'code'                  => $this->TYPE_VARCHAR_255,
            'template'              => $this->TYPE_TEXT_NULL,
            'template_config_id'    => $this->TYPE_FOREIGN_KEY,
            'parent_name_config_id' => $this->TYPE_FOREIGN_KEY,
            'parent_id'             => $this->TYPE_FOREIGN_KEY,
            'module_id'             => $this->TYPE_FOREIGN_KEY,
        ));
        $this->create_table('cms_layout');

        // content
        $this->add_cms_default_fields();
        $this->add_field(array(
            'code'                  => $this->TYPE_VARCHAR_255,
            'route_key'             => $this->TYPE_VARCHAR_255,
            'is_static'             => $this->TYPE_TINYINT_UNSIGNED_10,
            'route_to'              => $this->TYPE_VARCHAR_255_NULL,
            'content'               => $this->TYPE_VARCHAR_255_NULL,
            'content_config_id'     => $this->TYPE_FOREIGN_KEY,
            'module_id'             => $this->TYPE_FOREIGN_KEY,
            'layout_id'             => $this->TYPE_FOREIGN_KEY,
            'authenticated'         => $this->TYPE_TINYINT_UNSIGNED_10,
            'unauthenticated'       => $this->TYPE_TINYINT_UNSIGNED_10,
            'is_crucial'            => $this->TYPE_TINYINT_UNSIGNED_10,
        ));
        $this->create_table('cms_content');

        // content_group
        $this->add_cms_default_fields();
        $this->add_field(array(
            'group_id'      => $this->TYPE_FOREIGN_KEY,
            'content_id'    => $this->TYPE_FOREIGN_KEY,
        ));
        $this->create_table('cms_content_group');

        // navigation
        $this->add_cms_default_fields();
        $this->add_field(array(
            'name'          => $this->TYPE_VARCHAR_255,
            'content_id'    => $this->TYPE_FOREIGN_KEY,
            'parent_id'     => $this->TYPE_FOREIGN_KEY,
        ));
        $this->create_table('cms_navigation');
    }

    public function down()
    {
        $this->drop_table('cms_navigation');
        $this->drop_table('cms_content_group');
        $this->drop_table('cms_content');
        $this->drop_table('cms_layout');
        $this->drop_table('cms_user_group');
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
