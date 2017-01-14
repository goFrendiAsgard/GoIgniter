<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Group_Model;
use \Modules\Cms\Models\Content_Model;

class Content_Group_Model extends CMS_Model
{
    protected $_table = 'cms_content_group';
    protected $_columns = ['group_id', 'content_id'];
    protected $_unique_columns = ['group_id', 'content_id'];

    protected $_parents = array(
        'group' => array(
            'model' => __NAMESPACE__.'\Group_Model',
            'foreign_key' => 'group_id',
        ),
        'content' => array(
            'model' => __NAMESPACE__.'\Content_Model',
            'foreign_key' => 'content_id',
        ),
    );
}
