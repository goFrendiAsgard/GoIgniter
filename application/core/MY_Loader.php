<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{

    public function get_library_config($file)
    {
        // include library's configuration file
        if ( !file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/'.$file.'.php') && !file_exists($file_path = APPPATH.'config/'.$file.'.php'))
        {
            show_error('The configuration file '.$file.'.php does not exist.');
        }
        if(!is_readable($file_path))
        {
            show_error('The configuration file '.$file.'.php is not readable.');
        }
        $config = array();
        include($file_path);
        $original_config = $config;

        // include ext config file
        $config = array();
        $ext_config_path = EXTCONFIGPATH.'config/config.php';
        if (file_exists($ext_config_path) && is_readable($ext_config_path))
        {
            include($ext_config_path);
        }

        // override keys in $original_config
        $ext_prefix = $file.'.';
        $prefix_length = strlen($ext_prefix);
        foreach($config as $key=>$val)
        {
            if(substr($key, 0, $prefix_length) == $ext_prefix)
            {
                $original_config[substr($key,$prefix_length)] = $val;
            }
        }

        return $original_config;
    }

    public function database($params = '', $return = FALSE, $query_builder = NULL)
    {
        if($params === '')
        {
            // include database.php
            if ( !file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php') && !file_exists($file_path = APPPATH.'config/database.php'))
            {
                show_error('The configuration file database.php does not exist.');
            }
            if(!is_readable($file_path))
            {
                show_error('The configuration file database.php is not readable.');
            }
            // initiate default variables
            $active_group = 'default';
            $db = array($active_group => '');
            $query_builder = TRUE;
            include($file_path);

            // include extconfig
            $config = array();
            $ext_config_path = EXTCONFIGPATH.'config/config.php';
            if (file_exists($ext_config_path) && is_readable($ext_config_path))
            {
                include($ext_config_path);
            }

            // override keys in $db
            $ext_db_prefix = 'db.'.$active_group.'.';
            $prefix_length = strlen($ext_db_prefix);
            foreach($config as $key=>$val)
            {
                if(substr($key, 0, $prefix_length) == $ext_db_prefix)
                {
                    $db[$active_group][substr($key,$prefix_length)] = $val;
                }
            }

            // set params
            $params = $db[$active_group];
            var_dump($params);
        }
        return parent::database($params, $return, $query_builder);
    }

    public function library($library, $params = NULL, $object_name = NULL)
    {
        if(!is_array($library) && $params === NULL)
        {
            $params = $this ->get_library_config($library);
        }
        return parent::library($library, $params, $object_name);
    }

    public function driver($library, $params = NULL, $object_name = NULL)
    {
        if(!is_array($library) && $params === NULL)
        {
            $params = $this ->get_library_config($library);
        }
        return parent::driver($library, $params, $object_name);
    }
}
