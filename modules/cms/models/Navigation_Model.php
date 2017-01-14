<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Content_Model;

class Navigation_Model extends CMS_Model
{
    protected $_table = 'cms_layout';
    protected $_columns = ['code', 'content_id', 'parent_id'];
    protected $_unique_columns = ['code'];

    protected $_parents = array(
        'content' => array(
            'model' => __NAMESPACE__.'\Content_Model',
            'foreign_key' => 'content_id',
        ),
        'parent' => array(
            'model' => __NAMESPACE__.'\Navigation_Model',
            'foreign_key' => 'parent_id',
        )
    );
}
