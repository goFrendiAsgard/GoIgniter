<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Model;

class Module_Model extends CMS_Model
{
    protected $_table = 'cms_module';
    protected $_site_id    = '';
    protected $_site_model = '';
    protected $_columns = ['code'];
    protected $_unique_columns = ['code'];

    protected $_many_to_many = array(
        'sites' => array(
            'pivot_model' => __NAMESPACE__.'\Site_Module_Model',
            'relation' => 'site',
            'backref_relation' => 'module',
        ),
    );
}
