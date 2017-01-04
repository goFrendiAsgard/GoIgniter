<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_Migrator extends CI_Model
{
    protected $migration_config;
    protected $migration_error;

    public function __construct()
    {
        // get the pre-processed configuration
        $this->migration_config = $this->load->get_library_config('migration');
        $this->migration_error = array();

        $CI =& get_instance();
        $this->load->database();
        $this->load->dbforge();
    }

    public function get_error($module=NULL)
    {
        if($module === NULL)
        {
            return $this->migration_error;
        }
        else if(in_array($module, get_available_modules()))
        {
            if(array_key_exists($module, $this->migration_error))
            {
                return $this->migration_error[$module];
            }
            return 'Migration of '.$module.' is never performed';
        }
        return 'Module '.$module.' is not exists';
    }

    // mode can be "latest" or "current"
    // versions should be associative array with module names as key, and version number as value
    public function migrate_all($mode = 'latest', $versions = array())
    {
        foreach(get_available_modules() as $module)
        {
            $version = array_key_exists($module, $versions) ? $versions[$module] : NULL;
            $this->migrate($module, $mode, $version);
        }
    }

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

    public function migrate($module, $mode = 'latest', $version = NULL)
    {
        // if module doesn't have migrations directory, skip it
        if(!file_exists($this->get_migration_path($module))){
            $this->migration_error[$module] = 'Migration of '.$module.' is not available';
            return FALSE;
        }

        // make different configuration for each module
        $config = $this->migration_config;
        $config['migration_enabled'] = TRUE;
        $config['migration_table'] = $this->get_migration_table($module);
        $config['migration_path'] = $this->get_migration_path($module);
        if($version !== NULL)
        {
            $config['migration_version'] = $version;
        }

        $alias = 'migration_'.substr(md5($module), 0, 10);


        require_once(BASEPATH.'libraries/Migration.php');
        $migration = new \CI_Migration($config);


        if(($mode == 'latest' && $migration->latest()) || $migration->current())
        {
            $this->migration_error[$module] = $migration->error_string();
            return FALSE;
        }
        else
        {
            $this->migration_error[$module] = '';
        }
        return TRUE;
    }

}
