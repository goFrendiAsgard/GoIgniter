<?php defined('BASEPATH') OR exit('No direct script access allowed');

spl_autoload_register(function ($class)
{
    $class_parts = explode('\\', trim($class, '\\'));

    if(count($class_parts) > 1 && ($class_parts[0] == 'App' || $class_parts[0] == 'Modules') )
    {
        $classPrefix = $class_parts[0];
        $class_parts = array_slice($class_parts, 1);
        for($i=0; $i<count($class_parts); $i++)
        {
            if($i < count($class_parts)-1)
            {
                $class_parts[$i] = lcfirst($class_parts[$i]);
            }
            else
            {
                $class_parts[$i] = $class_parts[$i] . '.php';
            }
        }

        // determine fileName
        $file_name = $classPrefix == 'Modules'?
            MODULEPATH . implode('/', $class_parts):
            APPPATH . implode('/', $class_parts);

        if(file_exists($file_name) && is_readable($file_name))
        {
            require_once($file_name);
        }
    }
    else
    {
        // CI
        if(substr($class, 0, 3) == 'CI_')
        {
            $file_name = BASEPATH . 'core/' . substr($class,3) . '.php';
            if(file_exists($file_name) && is_readable($file_name))
            {
                require_once($file_name);
            }
        }
        // Core classes
        else
        {
            $file_name = APPPATH . 'core/' . $class . '.php';
            if(file_exists($file_name) && is_readable($file_name))
            {
                require_once($file_name);
            }
        }
    }

});


if(!function_exists('cache_resource'))
{
    function cache_resource($src, $dst)
    {
        // we cannot cache something that is not exists
        if(!file_exists($src)) return FALSE;

        // get path
        $dst_path_parts = explode(DIRECTORY_SEPARATOR, $dst);
        array_pop($dst_path_parts);

        // look for inexisting directories in the path
        $test_count = count($dst_path_parts);
        while(!file_exists(implode(DIRECTORY_SEPARATOR, array_slice($dst_path_parts, 0, $test_count))))
        {
            $test_count --;
        }

        // create all inexisting directories
        while($test_count < count($dst_path_parts))
        {
            @mkdir(implode(DIRECTORY_SEPARATOR, array_slice($dst_path_parts, 0, $test_count+1)));
            $test_count ++;
        }

        // The cached file is directory
        if(is_dir($src))
        {
            // create $dst if it is not exist
            file_exists($dst) || @mkdir($dst);

            // call this function again recursively for each files/directories inside $src
            $dir = opendir($src);
            while(false !== ( $file = readdir($dir)) )
            {
                if ($file=='.' || $file=='..')
                {
                    continue;
                }
                cache_resource($src . DIRECTORY_SEPARATOR . $file,
                    $dst . DIRECTORY_SEPARATOR . $file);
            }
            closedir($dir);

        }
        else if(!file_exists($dst) || (file_exists($dst) && date('YmdHis', filemtime($dst)) < date('YmdHis', filemtime($src))))
        {
            // cache file
            @copy($src, $dst);
        }
        return TRUE;
    }
}


if(!function_exists('cache_modules'))
{
    function cache_modules()
    {
        foreach(get_available_modules() as $module)
        {
            // cache the view
            cache_resource(MODULEPATH.$module.'/views', APPPATH.'views/modules/'.$module);
            // cache the assets
            cache_resource(MODULEPATH.$module.'/assets', ASSETPATH.'modules/'.$module);
        }
    }
}


if(!function_exists('get_available_modules'))
{
    function get_available_modules()
    {
        // get subdirectories in MODULEPATH
        $dirs = glob(MODULEPATH.'*', GLOB_ONLYDIR);

        // strip the subdirectories, so we get the path relative to MODULEPATH
        $module_list = array();
        foreach($dirs as $dir)
        {
            $module_list[] = str_replace(MODULEPATH, '', $dir);
        }

        return $module_list;
    }
}


if(!function_exists('helper'))
{
    function helper($helpers = array())
    {
        $helpers = is_string($helpers)? array($helpers) : $helpers;
        foreach($helpers as $helper)
        {
            $helper = trim($helper, '/');

            // first attempt, try to in module directory
            $file_name_parts = explode('/', $helper);
            if(count($file_name_parts) > 1)
            {
                $moduleName = $file_name_parts[0];
                $file_name_parts = array_slice($file_name_parts, 1);
                $file_name = MODULEPATH . $moduleName . '/helpers/' . implode('/', $file_name_parts) . '_helper.php';
                if(file_exists($file_name) && is_readable($file_name))
                {
                    require_once($file_name);
                    $found = TRUE;
                }
            }

            // second attempt, try to look helpers in application path
            $file_name = APPPATH . 'helpers/' . $helper . '_helper.php';
            if(file_exists($file_name) && is_readable($file_name))
            {
                require_once($file_name);
                $found = TRUE;
            }

            // third attempt, try to look helpers in base path
            $file_name = BASEPATH . 'helpers/' . $helper . '_helper.php';
            if(file_exists($file_name) && is_readable($file_name))
            {
                require_once($file_name);
                $found = TRUE;
            }

        }
    }
}


if(!function_exists('view'))
{
    function view($view, $vars = array(), $return = FALSE)
    {
        cache_modules();
        $view = trim($view, '.php') . '.php';
        $view_parts = explode('/', $view);

        $found = FALSE;
        // is it on modules?
        if(count($view_parts) > 1)
        {
            $file_name = MODULEPATH . $view_parts[0] . '/views/' . implode('/', array_slice($view_parts, 1));
            if(file_exists($file_name) && is_readable($file_name)){
                $cached_file_name = VIEWPATH . 'modules/' . implode('/', $view_parts);

                $found = file_exists($cached_file_name);

                // adjust the view
                $view = 'modules/' . $view;
            }
        }
        // No? then it must be on APPPATH
        if(!$found)
        {
            $file_name = VIEWPATH . $view;
            if(file_exists($file_name) && is_readable($file_name)){
                $found = TRUE;
            }
        }
        // still not found? show error
        if(!$found)
        {
            show_error('Unable to load the requested file: '.$file_name);
        }

        // call the original load view
        $_ci =& get_instance();
        return $_ci->load->view($view, $vars, $return);
    }
}


if(!function_exists('asset_url'))
{
    function asset_url($uri = '', $protocol = NULL)
    {
        cache_modules();
        $uri_parts = explode('/', $uri);
        if( count($uri_parts) > 1 && in_array($uri_parts[0], get_available_modules()) )
        {
            $module = $uri_parts[0];
            $uri = 'modules/' . $module . '/' . implode('/', array_slice($uri_parts, 1));
        }

        // in case of MY_Config never initialiezed, init MY_Config so that it will be cached
        if(empty(get_instance()->config->base_url()))
        {
            include_once(APPPATH.'core/MY_Config.php');
            new MY_Config();
        }
        return get_instance()->config->asset_url($uri, $protocol);
    }
}

if(!function_exists('base_url'))
{
    function base_url($uri = '', $protocol = NULL)
    {
        // in case of MY_Config never initialiezed, init MY_Config so that it will be cached
        if(empty(get_instance()->config->base_url()))
        {
            include_once(APPPATH.'core/MY_Config.php');
            new MY_Config();
        }
        return get_instance()->config->base_url($uri, $protocol);
    }
}


if(!function_exists('site_url'))
{
    function site_url($uri = '', $protocol = NULL)
    {
        // in case of MY_Config never initialiezed, init MY_Config so that it will be cached
        if(empty(get_instance()->config->base_url()))
        {
            include_once(APPPATH.'core/MY_Config.php');
            new MY_Config();
        }

        // site_url need special treatment
        $config = get_instance()->config;
        $hostname = $config->config['hostname'];
        $actual_hostname = $_SERVER['SERVER_NAME'];

        $site_url = $config->site_url($uri, $protocol);
        $site_url = str_replace('://'.$hostname, '://'.$actual_hostname, $site_url);
        return $site_url;
    }
}


if(!function_exists('run_module_controller'))
{
    function run_module_controller($url, $return = FALSE)
    {
        $available_modules = get_available_modules();
        $url = trim($url, '/');

        // variable to save the state
        $found = FALSE;
        $result = '';

        // explode url into url_parts and get_parts
        $url_parts = explode('?', $url);
        $get = count($url_parts) > 1? $url_parts[1] : '';
        $get_parts = explode('&', $get);
        $url_parts = explode('/', trim($url_parts[0], '/'));

        // save $_GET status, and override with the new one
        $old_GET = $_GET;
        foreach($get_parts as $pair){
            $pairPart = explode('=', $pair);
            if(count($pairPart) == 2){
                $key = $pairPart[0];
                $val = $pairPart[1];
                $_GET[$key] = $val;
            }
        }

        // nameSpace_parts is upercased url_parts
        $namespace_parts = array();
        foreach($url_parts as $part)
        {
            $namespace_parts[] = ucfirst($part);
        }

        // check in module directory
        $module = $url_parts[0];
        $test_parts = array_slice($url_parts, 1);

        if(in_array($module, $available_modules))
        {
            // Check: modules/directory/controller/function/parameter
            for($i=0; $i<count($test_parts); $i++)
            {
                $test_directory_parts = array_slice($test_parts, 0, $i);
                $test_class = ucfirst($test_parts[$i]);
                $test_function = $i+1 < count($test_parts)? $test_parts[$i+1] : 'index';
                $test_parameters = $i+2 < count($test_parts)? array_slice($test_parts,$i+2) : array();

                // determine namespace and file name
                $namespace = '\\Modules\\'.ucfirst($module).'\\Controllers\\' . implode('\\', array_slice($namespace_parts, 1, $i));
                $namespace = rtrim($namespace, '\\');
                $file_name = MODULEPATH . $module . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR .
                    (count($test_directory_parts) > 0? implode(DIRECTORY_SEPARATOR, $test_directory_parts) . DIRECTORY_SEPARATOR : '') .
                    $test_class . '.php';

                // get the result
                if(file_exists($file_name) && is_readable($file_name))
                {
                    $full_class = $namespace . '\\'.$test_class;
                    if(method_exists($full_class, $test_function)){
                        ob_start();
                        $obj = new $full_class();
                        call_user_func_array(array($obj, $test_function), $test_parameters);
                        $result = ob_get_contents();
                        @ob_end_clean();
                        $found = TRUE;
                        break;
                    }
                }
            }
        }

        // reset $_GET
        $_GET = $old_GET;

        if($found)
        {
            // done
            if($return)
            {
                return $result;
            }
            else
            {
                echo $result;
            }
        }
        else if((count($url_parts) == 1 || (count($url_parts) > 1 && $url_parts[0] != $url_parts[1])) && in_array($url_parts[0], $available_modules))
        {
            // case when url is blog/index, which should be corelated to blog/blog/index
            $url = $module . '/' . $url;
            return run_module_controller($url, $return);
        }

        return NULL;
    }
}

if(!function_exists('run_routed_module_url'))
{
    require_once(APPPATH.'core/route_config_loader.php');

    function run_routed_module_url($url, $return = FALSE)
    {
        $route = __load_route_config();
        $disable_autoroute = isset($route['disable_autoroute'])? $route['disable_autoroute'] : FALSE;
        $route = __sanitize_route($route);

        // start parsing
        foreach ($route as $key => $val)
        {
            // if $val is array, assume the request is use "GET" method 
            if (is_array($val))
            {
                $val = array_change_key_case($val, CASE_LOWER);
                if (isset($val['get']))
                {
                    $val = $val['get'];
                }
                else
                {
                    continue;
                }
            }

            // Convert wildcards to RegEx
            $key = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $key);

            // Does the RegEx match?
            if (preg_match('#^'.$key.'$#', $url))
            {
                $actual_url = preg_replace('#^'.$key.'$#', $val, $url);
                return run_module_controller($actual_url, $return);
            }
            // RegEx doesn't match? don't give up, it might contains some get queries
            else if(preg_match('#^'.$key.'?(.+)$#', $url, $matches))
            {
                $val = $val.'?'.$matches[count($matches)-1];
                $actual_url = preg_replace('#^'.$key.'\?(+*)$#', $val, $url);
                return run_module_controller($actual_url, $return);
            }
        }
        // all routes failed
        if(!$disable_autoroute)
        {
            return run_module_controller($url, $return);
        }
        return NULL;
    }
}
