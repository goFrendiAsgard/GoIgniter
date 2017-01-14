<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Module_Model;
use \Modules\Cms\Models\Site_Model;

class Site_Module_Model extends CMS_Model
{
    protected $_table = 'cms_site_module';
    protected $_columns = ['module_id', 'site_id'];
    protected $_unique_columns = ['module_id', 'site_id'];

    protected $_parents = array(
        'module' => array(
            'model' => __NAMESPACE__.'\Module_Model',
            'foreign_key' => 'module_id',
        ),
        'site' => array(
            'model' => __NAMESPACE__.'\Site_Model',
            'foreign_key' => 'site_id',
        ),
    );
}
