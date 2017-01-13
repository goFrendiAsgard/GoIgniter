<?php
namespace Modules\Cms\Models\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Module_Model;

class Config_Model extends CMS_Model
{
    protected $_table = 'cms_config';
    protected $_columns = ['module_id', 'type', 'key', 'value', 'json_options'];
    protected $_unique_columns = ['key'];

    protected $_parents = array(
        'module' => array(
            'model' => '\Modules\Cms\Models\Module_Model',
            'foreign_key' => 'module_id',
        ),
    );
}
