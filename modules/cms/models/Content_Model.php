<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Layout_Model;
use \Modules\Cms\Models\Config_Model;
use \Modules\Cms\Models\Module_Model;
use \Modules\Cms\Models\Content_Group_Model;

class Content_Model extends CMS_Model
{
    protected $_table = 'cms_content';
    protected $_columns = ['module_id', 'code', 'route_key', 'is_static', 'route_to', 'content', 'content_config_id', 'static_content', 'static_content_config_id', 'layout_id', 'authenticated', 'unauthenticated', 'is_crucial'];
    protected $_unique_columns = ['code'];

    public $authenticated = TRUE;
    public $unauthenticated = TRUE;
    public $is_crucial = FALSE;
    public $is_static = TRUE;

    protected $_parents = array(
        'module' => array(
            'model' => __NAMESPACE__.'\Module_Model',
            'foreign_key' => 'module_id',
        ),
        'content_default_config' => array(
            'model' => __NAMESPACE__.'\Config_Model',
            'foreign_key' => 'content_config_id',
        ),
        'static_content_default_config' => array(
            'model' => __NAMESPACE__.'\Config_Model',
            'foreign_key' => 'static_content_config_id',
        ),
        'layout' => array(
            'model' => __NAMESPACE__.'\Layout_Model',
            'foreign_key' => 'layout_id',
        ),
    );

    protected $_many_to_many = array(
        'groups' => array(
            'pivot_model' => __NAMESPACE__.'\Content_Group_Model',
            'relation' => 'group',
            'backref_relation' => 'content',
        ),
    );
}
