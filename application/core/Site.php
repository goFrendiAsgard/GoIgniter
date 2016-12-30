<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Unfortunately, this might be used before database load (i.e: in router)
// Thus, this must be independent from database
class Site
{
    private $_dir_path;

    public function __construct()
    {
        // define properties
        $this->_dir_path = EXTCONFIGPATH.'config/sites/';
        $this->_dictionary_file = EXTCONFIGPATH.'config/sites/dict.json';
        $this->_dictionary = array();

        // create directory
        if(!file_exists($this->_dir_path))
        {
            mkdir($this->_dir_path);
        }
    }

    public function get_code_file_name($code)
    {
        return $this->_dir_path.'code_'.$code.'.json';
    }

    public function get_alias_file_name($alias)
    {
        return $this->_dir_path.'alias_'.$alias;
    }

    public function get_available_site_codes()
    {
        $codes = array();
        if(file_exists($this->_dir_path))
        {
            $files = glob($this->_dir_path.'code_*.json');
            foreach($files as $file)
            {
                $file = basename($file);
                $codes[] = substr($file, 5, strlen($file)-10);
            }
        }
        return $codes;
    }

    public function is_main_site()
    {
        // this is main site if config['hostname'] is not defined
        // or config['hostname] is defined and equal to acatual server name
        $config = array();
        if(file_exists(EXTCONFIGPATH.'config/config.php'))
        {
            include(EXTCONFIGPATH.'config/config.php');
        }
        return !array_key_exists('hostname', $config) || $_SERVER['SERVER_NAME'] == $config['hostname'];
    }

    public function get_current_code()
    {
        // get from alias cache
        $actual_hostname = $_SERVER['SERVER_NAME'];
        $code = $this->get_code_by_alias($actual_hostname);
        if($code !== NULL){
            return $code;
        }

        // hostname not found, try subdomain
        $config = array();
        if(file_exists(EXTCONFIGPATH.'config/config.php'))
        {
            include(EXTCONFIGPATH.'config/config.php');
        }
        if(isset($config['hostname']))
        {
            $config_hostname = $config['hostname'];
            if(substr($actual_hostname, strlen($actual_hostname)-strlen($config_hostname)) == $config_hostname)
            {
                $code = substr($actual_hostname, 0, strlen($actual_hostname)-strlen($config_hostname)-1);
                if(file_exists($this->get_code_file_name($code)))
                {
                    return $code;
                }
            }
        }
        return NULL;
    }

    public function get_code_by_alias($alias)
    {
        if(file_exists($this->get_alias_file_name($alias)))
        {
            return file_get_contents($this->get_alias_file_name($alias));
        }
        return NULL;
    }

    public function get_aliases_by_code($code)
    {
        $aliases = array();
        if(file_exists($this->get_code_file_name($code)))
        {
            $aliases = json_decode(file_get_contents($this->get_code_file_name($code)));
        }
        return $aliases;
    }

    public function add_site($code, $aliases=array())
    {
        if(preg_match('/[a-z]+/si', $code))
        {
            if(!file_exists($this->get_code_file_name($code)))
            {
                $new_aliases = array();
                foreach($aliases as $alias)
                {
                    if(!file_exists($this->_dir_path.'alias_'.$alias))
                    {
                        $new_aliases[] = $alias;

                        // write alias file
                        file_put_contents($this->get_alias_file_name($alias), $code);
                    }
                }

                // write code file
                $content = json_encode($new_aliases);
                file_put_contents($this->get_code_file_name($code), $content);
            }
        }
    }

    public function delete_site($code)
    {
        // delete alias cache
        $aliases = $this->get_aliases_by_code($code);
        foreach($aliases as $alias)
        {
            // delete alias file
            $this->delete_site_alias($code, $alias);
        }

        // delete code file
        if(file_exists($this->get_code_file_name($code)))
        {
            unlink($this->get_code_file_name($code));
        }
    }

    public function add_site_alias($code, $alias)
    {
        if(!file_exists($this->get_alias_file_name($alias)))
        {
            // add alias cache
            file_put_contents($this->get_alias_file_name($alias), $code);

            $aliases = $this->get_aliases_by_code($code);
            $aliases[] = $alias;
            file_put_contents($this->get_code_file_name($code), json_encode($aliases));
        }
    }

    public function delete_site_alias($code, $alias)
    {
        if(file_exists($this->get_alias_file_name($alias)))
        {
            // remove alias cache
            unlink($this->get_alias_file_name($alias));

            // rewrite file
            $aliases = $this->get_aliases_by_code($code);
            $new_aliases = array();
            foreach($aliases as $old_alias)
            {
                if($old_alias != $alias)
                {
                    $new_aliases[] = $old_alias;
                }
            }

            // save dictionary
            file_put_contents($this->get_code_file_name($code), json_encode($new_aliases));
        }
    }

}
