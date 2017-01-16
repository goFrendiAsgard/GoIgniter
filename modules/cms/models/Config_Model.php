<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Historical_Model;
use \Modules\Cms\Models\Module_Model;

class Config_Model extends CMS_Historical_Model
{
    protected $_table = 'cms_config';
    protected $_columns = ['module_id', 'type', 'key', 'value', 'json_options', 'description'];
    protected $_unique_columns = ['key'];
    protected $_history_foreign_key = 'config_id';
    protected $_history_columns = ['value'];

    protected $_parents = array(
        'module' => array(
            'model' => __NAMESPACE__.'\Module_Model',
            'foreign_key' => 'module_id',
        ),
    );


    protected function get_options()
    {
        return json_decode($this->json_options, TRUE);
    }

    protected function set_options($val)
    {
        $this->json_options = json_encode($val);
    }

}
