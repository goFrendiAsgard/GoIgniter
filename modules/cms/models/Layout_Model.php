<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Module_Model;
use \Modules\Cms\Models\Config_Model;

class Layout_Model extends CMS_Model
{
    protected $_table = 'cms_layout';
    protected $_columns = ['module_id', 'code', 'template', 'parent_id'];
    protected $_unique_columns = ['code'];

    protected $_parents = array(
        'module' => array(
            'model' => __NAMESPACE__.'\Module_Model',
            'foreign_key' => 'module_id',
        ),
        'parent' => array(
            'model' => __NAMESPACE__.'\Layout_Model',
            'foreign_key' => 'parent_id',
        )
    );
}
