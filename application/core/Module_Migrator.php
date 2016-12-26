<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_Migrator extends CI_Model
{
    // mode can be "latest" or "current"
    // versions should be associative array with module names as key, and version number as value
    public function migrate($mode = 'latest', $versions = array())
    {
        // get the pre-processed configuration
        $migration_config = $this->load->get_library_config('migration');
        $migration_error = array();

        foreach(get_available_modules() as $module)
        {
            // if module doesn't have migrations directory, skip it
            if(!file_exists(MODULEPATH.$module.'/migrations')){
                continue;
            }

            // make different configuration for each module
            $config = $migration_config;
            $config['migration_enabled'] = TRUE;
            $config['migration_table'] = $module.'_'.$config['migration_table'];
            $config['migration_path'] = MODULEPATH.$module.'/migrations';
            if(array_key_exists($module, $versions))
            {
                $config['migration_version'] = $versions[$module];
            }
            
            $alias = 'migration_'.substr(md5($module), 0, 10);
            $this->load->library('migration', $config, $alias);

            $migration = $this->{$alias};

            var_dump($migration->find_migrations());
            if(($mode == 'latest' && $migration->latest() === FALSE) || $migration->current() === FALSE)
            {
                $migration_error[$module] = $migration->error_string();
            }

        }
        return $migration_error;
    }
}
