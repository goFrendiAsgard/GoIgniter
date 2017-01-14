<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Module_Model;
use \Modules\Cms\Models\User_Group_Model;
use \Modules\Cms\Models\Content_Group_Model;

class Group_Model extends CMS_Model
{
    protected $_table = 'cms_group';
    protected $_columns = ['code', 'module_id'];
    protected $_unique_columns = ['code'];

    protected $_parents = array(
        'module' => array(
            'model' => __NAMESPACE__.'\Module_Model',
            'foreign_key' => 'module_id',
        )
    );

    protected $_many_to_many = array(
        'users' => array(
            'pivot_model' => __NAMESPACE__.'\User_Group_Model',
            'relation' => 'user',
            'backref_relation' => 'group',
        ),
        'contents' => array(
            'pivot_model' => __NAMESPACE__.'\Content_Group_Model',
            'relation' => 'content',
            'backref_relation' => 'group',
        ),
    );
}
