<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Module_Model;

class Config_Model extends CMS_Model
{
    protected $_table = 'cms_config';
    protected $_columns = ['module_id', 'type', 'key', 'value', 'json_options', 'description'];
    protected $_unique_columns = ['key'];

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
