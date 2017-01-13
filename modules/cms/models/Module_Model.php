<?php
namespace Modules\Cms\Models\Models;
use \Modules\Cms\CMS_Model;

class Module_Model extends CMS_Model
{
    protected $_table = 'cms_module';
    protected $_columns = ['code'];
    protected $_unique_columns = ['code'];
}
