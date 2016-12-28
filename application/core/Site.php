<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Site
{
    private $_dir_path;
    private $_dictionary_file;
    private $_dictionary;

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

        if(!file_exists($this->_dictionary_file))
        {
            file_put_contents($this->_dictionary_file, json_encode($this->_dictionary));
        }

        // initiate _dictionary
        $json = file_get_contents($this->_dictionary_file);
        $this->_dictionary = json_decode($json, TRUE);
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

    public function get_current_site_code()
    {
        // get from alias cache
        $actual_hostname = $_SERVER['SERVER_NAME'];
        if(file_exists($this->_dir_path.'alias_'.$actual_hostname))
        {
            return file_get_contents($this->_dir_path.'alias_'.$actual_hostname);
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
                $code = substr($actual_hostname, 0, strlen($actual_hostname)-strlen($config_hostname));
                if(array_key_exists($code, $this->_dictionary))
                {
                    return $code;
                }
            }
        }

        return NULL;
    }

    public function add_site($code, $aliases=array())
    {
        if(preg_match('/[a-z]+/si', $code))
        {
            if(!array_key_exists($code, $this->_dictionary))
            {
                foreach($aliases as $alias)
                {
                    if(!file_exists($this->_dir_path.'alias_'.$alias))
                    {
                        $new_aliases[] = $alias;
                        file_put_contents($this->_dir_path.'alias_'.$alias, $code);
                    }
                }
                $this->_dictionary[$code] = $new_aliases;

                // save dictionary
                file_put_contents($this->_dictionary_file, json_encode($this->_dictionary));
            }
        }
    }

    public function delete_site($code)
    {
        // delete alias cache
        $aliases = $this->_dictionary[$code];
        foreach($aliases as $alias)
        {
            unlink($this->_dir_path.'alias_'.$alias);
        }
        unset($this->_dictionary[$code]);

        // save dictionary
        file_put_contents($this->_dictionary_file, json_encode($this->_dictionary));
    }

    public function add_site_alias($code, $alias)
    {
        if(!file_exists($this->_dir_path.'alias_'.$alias))
        {
            // add alias cache
            file_put_contents($this->_dir_path.'alias_'.$alias, $code);

            // add dictionary
            $this->_dictionary[$code][] = $alias;

            // save dictionary
            file_put_contents($this->_dictionary_file, json_encode($this->_dictionary));
        }
    }

    public function remove_site_alias($code, $alias)
    {
        if(file_exists($this->_dir_path.'alias_'.$alias))
        {
            // remove alias cache
            unlink($this->_dir_path.'alias_'.$alias);

            // rewrite file
            $aliases = $this->_dictionary[$code];
            $new_aliases = array();
            foreach($aliases as $old_alias)
            {
                if($old_alias != $alias)
                {
                    $new_aliases[] = $alias;
                }
            }
            $this->_dictionary[$code] = $new_aliases;

            // save dictionary
            file_put_contents($this->_dictionary_file, json_encode($this->_dictionary));
        }
    }

}
