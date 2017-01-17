<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Historical_Model;
use \Modules\Cms\Models\Module_Model;
use \Modules\Cms\Models\Config_Model;
use \Modules\Cms\Models\Site_Model;

class Layout_Model extends CMS_Historical_Model
{
    protected $_table = 'cms_layout';
    protected $_columns = ['module_id', 'code', 'template', 'parent_id'];
    protected $_unique_columns = ['code'];

    protected $_history_foreign_key = 'layout_id';
    protected $_history_columns = ['template', 'parent_id'];

    protected $_parents = array(
        'module' => array(
            'model' => __NAMESPACE__.'\Module_Model',
            'foreign_key' => 'module_id',
        ),
        'parent' => array(
            'model' => __NAMESPACE__.'\Layout_Model',
            'foreign_key' => 'parent_id',
        )
    );

    protected function get_physical_name($code = NULL)
    {
        if($code === NULL)
        {
            $code = $this->code;
        }

        // return the physical name
        if($this->site === NULL)
        {
            return 'site_main_'.$code;
        }
        else
        {
            return 'site_'.$this->site_id.'_'.$code;
        }
    }

    protected function get_actual_file_name()
    {
        return MODULEPATH.'cms/views/layouts/'.$this->get_physical_name().'.html';
    }

    protected function get_actual_content()
    {
        $content = $this->template;
        if($this->parent != NULL)
        {
            $content = '{% extends "cms/layouts/' . $this->parent->get_physical_name() . '.html" %}' . PHP_EOL . $content;
        }
        return $content;
    }

    protected function after_save(&$success, &$error_message)
    {
        parent::after_save($success, $error_messsage);
        $file_name = $this->get_actual_file_name();
        file_put_contents($file_name, $this->get_actual_content());
    }

    protected function after_delete(&$success, &$error_message)
    {
        parent::after_delete($success, $error_message);
        $file_name = $this->get_actual_file_name();
        if(file_exists($file_name))
        {
            unlink($file_name);
        }
    }

    protected function after_purge(&$success, &$error_message)
    {
        parent::after_purge($success, $error_message);
        $file_name = $this->get_actual_file_name();
        if(file_exists($file_name))
        {
            unlink($file_name);
        }
    }
}
