<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Site_Alias_Model;

class Site_Alias_Model extends CMS_Model
{
    protected $_table = 'cms_site_alias';
    protected $_site_id = '';
    protected $_site_model = '';
    protected $_columns = ['alias', 'site_id'];
    protected $_unique_columns = ['alias'];

    protected $_parents = array(
        'site' => array(
            'model' => __NAMESPACE__.'\Site_Model',
            'foreign_key' => 'site_id',
        )
    );
}
