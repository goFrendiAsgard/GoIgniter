<?php
namespace Modules\Cms;
use \Module_Migrator as Core_Migrator;

class Module_Migrator extends Core_Migrator
{

    // TODO: we can only complete this after Model & Entity is ready
    protected function get_migration_table($module)
    {
        $config = $this->migration_config;
        return $config['migration_table'].'_'.$module;
    }

    protected function get_migration_path($module)
    {
        $config = $this->migration_config;
        return MODULEPATH.$module.'/migrations';
    }

}
