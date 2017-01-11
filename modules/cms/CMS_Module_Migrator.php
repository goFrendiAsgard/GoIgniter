<?php
namespace Modules\Cms;
use \Site;
use \Modules\Cms\Site_Model;

class CMS_Module_Migrator extends \Module_Migrator 
{
    protected function get_migration_table($module)
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
            $site_list = Site_Model::find_where('code', $current_site_code);
            if(count($site_list) > 0)
            {
                $current_site = $site_list[0];
                $table_suffix = '_site_'.$current_site->id;
            }
        }
        
        $config = $this->migration_config;
        return $config['migration_table'] . '_' . $module . $table_suffix;
    }

    protected function get_migration_path($module)
    {
        $config = $this->migration_config;
        return MODULEPATH.$module.'/migrations/site';
    }
}
