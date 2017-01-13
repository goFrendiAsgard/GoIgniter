<?php
namespace Modules\Cms\Models\Cms;
use \Modules\Cms\CMS_Model;

class Group_Model extends CMS_Model
{
    protected $_table = 'cms_group';
    protected $_columns = ['code'];
    protected $_unique_columns = ['code'];
}
