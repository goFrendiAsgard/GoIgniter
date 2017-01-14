<?php
namespace Modules\Cms\Models\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Module_Model;
use \Modules\Cms\Models\Config_Model;

class Layout_Model extends CMS_Model
{
    protected $_table = 'cms_layout';
    protected $_columns = ['module_id', 'code', 'template', 'template_config_id', 'parent_name_config_id', 'parent_id'];
    protected $_unique_columns = ['code'];

    protected $_parents = array(
        'module' => array(
            'model' => __NAMESPACE__.'\Module_Model',
            'foreign_key' => 'module_id',
        ),
        'default_template_config' => array(
            'model' => __NAMESPACE__.'\Config_Model',
            'foreign_key' => 'template_config_id',
        ),
        'default_parent_name_config' => array(
            'model' => __NAMESPACE__.'\Config_Model',
            'foreign_key' => 'parent_name_config_id',
        ),
        'parent' => array(
            'model' => __NAMESPACE__.'\Layout_Model',
            'foreign_key' => 'parent_id',
        )
    );
}
