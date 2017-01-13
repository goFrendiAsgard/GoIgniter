<?php
namespace Modules\Cms\Models\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Layout_Model;
use \Modules\Cms\Models\Config_Model;
use \Modules\Cms\Models\Module_Model;

class Content_Model extends CMS_Model
{
    protected $_table = 'cms_content';
    protected $_columns = ['module_id', 'code', 'route_key', 'is_static', 'route_to', 'content', 'content_config_id', 'static_content', 'static_content_config_id', 'layout_id', 'authenticated', 'is_crucial'];
    protected $_unique_columns = ['code'];

    protected $_parents = array(
        'module' => array(
            'model' => '\Modules\Cms\Models\Module_Model',
            'foreign_key' => 'module_id',
        ),
        'content_default_config' => array(
            'model' => '\Modules\Cms\Models\Config_Model',
            'foreign_key' => 'content_config_id',
        ),
        'static_content_default_config' => array(
            'model' => '\Modules\Cms\Models\Config_Model',
            'foreign_key' => 'static_content_config_id',
        ),
        'layout' => array(
            'model' => '\Modules\Cms\Models\Layout_Model',
            'foreign_key' => 'layout_id',
        ),
    );
}
