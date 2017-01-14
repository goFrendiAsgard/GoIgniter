<?php
namespace Modules\Cms\Models\Models;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\Group_Model;
use \Modules\Cms\Models\User_Model;

class User_Group_Model extends CMS_Model
{
    protected $_table = 'cms_user_group';
    protected $_columns = ['group_id', 'user_id'];
    protected $_unique_columns = ['group_id', 'user_id'];

    protected $_parents = array(
        'group' => array(
            'model' => __NAMESPACE__.'\Group_Model',
            'foreign_key' => 'group_id',
        ),
        'user' => array(
            'model' => __NAMESPACE__.'\User_Model',
            'foreign_key' => 'user_id',
        ),
    );
}
