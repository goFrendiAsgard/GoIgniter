<?php defined('BASEPATH') OR exit('No direct script access allowed');
use \Modules\Cms\CMS_Migration;

class Migration_Init_cms extends CMS_Migration {

    public function up()
    {
        // test_node
        $this->add_cms_default_fields();
        $this->add_field(array(
            'code'          => $this->TYPE_VARCHAR_255,
            'parent_id'     => $this->TYPE_FOREIGN_KEY,
            'child_count'   => $this->TYPE_INT_20_UNSIGNED_NULL,
        ));
        $this->create_table('test_node');

        // test_node_marriage
        $this->add_cms_default_fields();
        $this->add_field(array(
            'husband_id'    => $this->TYPE_FOREIGN_KEY,
            'wife_id'       => $this->TYPE_FOREIGN_KEY,
        ));
        $this->create_table('test_node_marriage');

        // module: List of registered cms modules
        $this->add_cms_general_default_fields();
        $this->add_field(array(
            'code'      => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_module');

        // site: List of registered sites
        $this->add_cms_general_default_fields();
        $this->add_field(array(
            'code'          => $this->TYPE_VARCHAR_255,
            'super_user_id' => $this->TYPE_FOREIGN_KEY,
        ));
        $this->create_table('cms_site');

        // site_alias: alias of the registered sites
        $this->add_cms_default_fields();
        $this->add_field(array(
            'alias'     => $this->TYPE_VARCHAR_255,
        ));
        $this->create_table('cms_site_alias');

        // site_module: flag, whether a module is available for a site or not. Main site has everything in cms_module accessible
        $this->add_cms_general_default_fields();
        $this->add_field(array(
            'module_id' => $this->TYPE_FOREIGN_KEY,
            'site_id'   => $this->TYPE_FOREIGN_KEY,
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
            'description'   => $this->TYPE_TEXT_NULL,
        ));
        $this->create_table('cms_config');

        // config_history
        $this->add_field(array(
            'id'         => $this->TYPE_PRIMARY_KEY,
            'changed_on' => $this->TYPE_DATETIME_NULL,
            'config_id'  => $this->TYPE_FOREIGN_KEY,
            'value'      => $this->TYPE_VARCHAR_255_NULL,
        ));
        $this->add_key('id');
        $this->create_table('cms_config_history');

        // group
        $this->add_cms_default_fields();
        $this->add_field(array(
            'module_id'     => $this->TYPE_FOREIGN_KEY,
            'code'    => $this->TYPE_VARCHAR_255,
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
            'parent_id'             => $this->TYPE_FOREIGN_KEY,
            'module_id'             => $this->TYPE_FOREIGN_KEY,
        ));
        $this->create_table('cms_layout');

        // layout_history
        $this->add_field(array(
            'id'                    => $this->TYPE_PRIMARY_KEY,
            'changed_on'            => $this->TYPE_DATETIME_NULL,
            'layout_id'             => $this->TYPE_FOREIGN_KEY,
            'template'              => $this->TYPE_VARCHAR_255_NULL,
            'parent_id'             => $this->TYPE_FOREIGN_KEY,
        ));
        $this->add_key('id');
        $this->create_table('cms_layout_history');

        // content
        $this->add_cms_default_fields();
        $this->add_field(array(
            'code'                  => $this->TYPE_VARCHAR_255,
            'route_key'             => $this->TYPE_VARCHAR_255,
            'is_static'             => $this->TYPE_TINYINT_UNSIGNED_10,
            'route_to'              => $this->TYPE_VARCHAR_255_NULL,
            'content'               => $this->TYPE_VARCHAR_255_NULL,
            'static_content'        => $this->TYPE_VARCHAR_255_NULL,
            'module_id'             => $this->TYPE_FOREIGN_KEY,
            'layout_id'             => $this->TYPE_FOREIGN_KEY,
            'authenticated'         => $this->TYPE_TINYINT_UNSIGNED_10,
            'unauthenticated'       => $this->TYPE_TINYINT_UNSIGNED_10,
            'is_crucial'            => $this->TYPE_TINYINT_UNSIGNED_10,
        ));
        $this->create_table('cms_content');

        // cms_content_history
        $this->add_field(array(
            'id'                    => $this->TYPE_PRIMARY_KEY,
            'changed_on'            => $this->TYPE_DATETIME_NULL,
            'content_id'            => $this->TYPE_FOREIGN_KEY,
            'route_key'             => $this->TYPE_VARCHAR_255,
            'is_static'             => $this->TYPE_TINYINT_UNSIGNED_10,
            'route_to'              => $this->TYPE_VARCHAR_255_NULL,
            'content'               => $this->TYPE_VARCHAR_255_NULL,
            'static_content'        => $this->TYPE_VARCHAR_255_NULL,
            'layout_id'             => $this->TYPE_FOREIGN_KEY,
            'authenticated'         => $this->TYPE_TINYINT_UNSIGNED_10,
            'unauthenticated'       => $this->TYPE_TINYINT_UNSIGNED_10,
        ));
        $this->add_key('id');
        $this->create_table('cms_content_history');

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
            'code'          => $this->TYPE_VARCHAR_255,
            'content_id'    => $this->TYPE_FOREIGN_KEY,
            'parent_id'     => $this->TYPE_FOREIGN_KEY,
        ));
        $this->create_table('cms_navigation');
    }

    public function down()
    {
        $this->drop_table('cms_navigation');
        $this->drop_table('cms_content_group');
        $this->drop_table('cms_content_history');
        $this->drop_table('cms_content');
        $this->drop_table('cms_layout_history');
        $this->drop_table('cms_layout');
        $this->drop_table('cms_user_group');
        $this->drop_table('cms_user');
        $this->drop_table('cms_group');
        $this->drop_table('cms_config_history');
        $this->drop_table('cms_config');
        $this->drop_table('cms_site_module');
        $this->drop_table('cms_site_alias');
        $this->drop_table('cms_site');
        $this->drop_table('cms_module');
        $this->drop_table('test_node_marriage');
        $this->drop_table('test_node');
    }
}
