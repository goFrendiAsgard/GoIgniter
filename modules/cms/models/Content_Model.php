<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Historical_Model;
use \Modules\Cms\Models\Layout_Model;
use \Modules\Cms\Models\Config_Model;
use \Modules\Cms\Models\Module_Model;
use \Modules\Cms\Models\Content_Group_Model;

class Content_Model extends CMS_Historical_Model
{
    protected $_table = 'cms_content';
    protected $_columns = ['module_id', 'code', 'route_key', 'is_static', 'route_to', 'content', 'static_content', 'layout_id', 'authenticated', 'unauthenticated', 'is_crucial'];
    protected $_unique_columns = ['code'];

    protected $_history_foreign_key = 'content_id';
    protected $_history_columns = ['route_key', 'is_static', 'route_to', 'content', 'static_content', 'layout_id', 'authenticated', 'unauthenticated'];

    public $authenticated = TRUE;
    public $unauthenticated = TRUE;
    public $is_crucial = FALSE;
    public $is_static = TRUE;

    protected $_parents = array(
        'module' => array(
            'model' => __NAMESPACE__.'\Module_Model',
            'foreign_key' => 'module_id',
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
