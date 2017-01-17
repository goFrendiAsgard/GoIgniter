<?php
namespace Modules\Cms\Models;
use \Modules\Cms\CMS_Module_Migrator;
use \Modules\Cms\CMS_Model;
use \Modules\Cms\Models\User_Model;
use \Modules\Cms\Models\Site_Alias_Model;
use \Modules\Cms\Models\Site_Module_Model;
use \Modules\Cms\Models\Module_Model;
use \Site;

class Site_Model extends CMS_Model
{
    protected static $core_site; // instance of application/core/Site.php
    protected $_table = 'cms_site';
    protected $_site_id    = '';
    protected $_site_model = '';
    protected $_columns = ['code', 'super_user_id'];
    protected $_unique_columns = ['code'];

    protected $real_old_site_code = NULL;

    protected $_parents = array(
        'super_admin' => array(
            'model' => __NAMESPACE__.'\User_Model',
            'foreign_key' => 'super_user_id',
        )
    );

    protected $_children = array(
        'aliases' => array(
            'model' => __NAMESPACE__.'\Site_Alias_Model',
            'foreign_key' => 'site_id',
        )
    );

    protected $_many_to_many = array(
        'modules' => array(
            'pivot_model' => __NAMESPACE__.'\Site_Module_Model',
            'relation' => 'module',
            'backref_relation' => 'site',
        )
    );

    public static function get_current_site()
    {
        $site = new Site();
        $site_code = $site->get_current_code();
        if($site_code != NULL)
        {
            $site_list = static::find_where('code', $site_code);
            if(count($site_list) > 0)
            {
                return $site_list[0];
            }
        }
        return NULL;
    }

    public static function get_registered_modules($site = NULL)
    {
        // if no parameter, use current site
        if($site == NULL)
        {
            $site = static::get_current_site();
        }

        // if site is null, all record in module table are "registered"
        if($site == NULL)
        {
            // all modules 
            return Module_Model::find_where(array(
                'deleted' => FALSE,
            ));
        }
        else
        {
            // current site's modules
            return $site->modules;
        }
    }

    // module can be string or object
    public static function is_module_registered($module)
    {
        foreach(static::get_registered_modules() as $registered_module)
        {
            if($registered_module == $module || $registered_module->code == $module)
            {
                return TRUE;
            }
        }
        return FALSE;
    }

    // module can be string or object
    public static function register_module($module, $db = NULL)
    {
        // if $module is string, try to get from database
        if(is_string($module))
        {
            $module_list = Module_Model::find_where(array('deleted' => FALSE, 'code' => $module));
            if(count($module_list) > 0)
            {
                $module = $module_list[0];
            }
        }

        // if $module is array, change it into object
        $module = static::data_to_entity($module, '\Modules\Cms\Models\Module_Model', $db);

        // if module is not registered, register it
        if(!static::is_module_registered($module))
        {
            $current_site = static::get_current_site();
            if($current_site == NULL)
            {
                $module->save();
            }
            else
            {
                // get module from database
                $module_list = Module_Model::find_where(array(
                    'deleted' => FALSE,
                    'code' => $module->code,
                ));
                if(count($module_list) > 0)
                {
                    $module = $module_list[0];
                    $current_site->add_modules($module);
                    $current_site->save();
                }
            }
        }
    }

    protected function get_real_old_site_code()
    {
        $this->real_old_site_code = NULL;
        if($this->id != NULL)
        {
            $old_site = Site_Model::find_by_id($this->id);
            $this->real_old_site_code = $old_site->code;
        }
    }

    protected function delete_old_site()
    {
        if($this->real_old_site_code != NULL)
        {
            $site = new Site();
            $site->delete_site($this->real_old_site_code);
        }
    }

    public function before_save(&$success, &$error_message)
    {
        parent::before_save($success, $error_message);
        $this->get_real_old_site_code();
    }

    public function before_delete(&$success, &$error_message)
    {
        parent::before_delete($success, $error_message);
        $this->get_real_old_site_code();
    }

    public function before_purge(&$success, &$error_message)
    {
        parent::before_purge($success, $error_message);
        $this->get_real_old_site_code();
    }

    public function after_save(&$success, &$error_message)
    {
        parent::after_save($success, $error_message);
        $this->delete_old_site();

        $aliases = array();
        foreach($this->aliases as $alias)
        {
            $aliases[] = $alias->alias;
        }

        $site = new Site();
        $site->add_site($this->code, $aliases);
    }

    public function after_delete(&$success, &$error_message)
    {
        parent::after_delete($success, $error_message);
        $this->delete_old_site();
    }

    public function after_purge(&$success, &$error_message)
    {
        parent::after_purge($success, $error_message);
        $this->delete_old_site();
    }

}
