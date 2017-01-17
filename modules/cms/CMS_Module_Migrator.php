<?php
namespace Modules\Cms;
use \Site;
use \Modules\Cms\Models\Site_Model;

class CMS_Module_Migrator extends \Module_Migrator 
{
    public function get_migration_table($module)
    {
        $table_suffix = '_invalid';
        // get current site code
        $site = new Site();
        if($site->is_main_site())
        {
            $table_suffix = '_site_main';
        }
        else
        {
            $current_site_code = $site->get_current_code();
            $site_list = Site_Model::find_where(array('code' => $current_site_code, 'deleted' => FALSE));
            if(count($site_list) > 0)
            {
                $current_site = $site_list[0];
                $table_suffix = '_site_'.$current_site->id;
            }
        }
        
        $config = $this->migration_config;
        return $config['migration_table'] . '_' . $module . $table_suffix;
    }

    public function get_migration_path($module)
    {
        $config = $this->migration_config;
        return MODULEPATH.$module.'/migrations/site';
    }

    public function migrate($module, $mode = 'latest', $version = NULL)
    {
        if(Site_Model::is_module_registered($module))
        {
            // also migrate by using Module_Migrator mechanism
            if($mode == 'latest')
            {
                $module_migrator = new \Module_Migrator();
                $error = $module_migrator->migrate($module, $mode, $version);
            }
            return parent::migrate($module, $mode, $version);
        }
        else
        {
            $this->migration_error[$module] = 'Migration of '.$module.' is not allowed';
            return FALSE;
        }
    }
}
