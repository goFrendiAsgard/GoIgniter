<?php

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
            include($file_name);
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
                include($file_name);
            }
        }
        // Core classes
        else
        {
            $file_name = APPPATH . 'core/' . $class . '.php';
            if(file_exists($file_name) && is_readable($file_name))
            {
                include($file_name);
            }
        }
    }

});


if(!function_exists('cache_file'))
{
    function cache_file($original_file_name, $cached_file_name)
    {
        // if original_file exists, and cached_file not exists or not up to date, then copy original_file to cache_file
        if(file_exists($original_file_name))
        {
            if(!file_exists($cached_file_name) || (file_exists($cached_file_name) && date('YmdHis', filemtime($cached_file_name)) < date('YmdHis', filemtime($original_file_name))))
            {

                // create subdirectory
                $path_parts = explode(DIRECTORY_SEPARATOR, $cached_file_name);
                for($i=1; $i<count($path_parts); $i++)
                {
                    $sub_path = implode(DIRECTORY_SEPARATOR, array_slice($path_parts, 0, $i));
                    file_exists($sub_path) || @mkdir($sub_path);
                }

                // cache file
                @copy($original_file_name, $cached_file_name);
            }
        }
        return file_exists($cached_file_name);
    }
}

if(!function_exists('rcopy'))
{
    function rcopy($src, $dst)
    {
        $dir = opendir($src);
        if(!file_exists($dst))
        {
            @mkdir($dst);
        }

        while(false !== ( $file = readdir($dir)) )
        {
            if (( $file != '.' ) && ( $file != '..' ))
            {
                if ( is_dir($src . DIRECTORY_SEPARATOR . $file) )
                {
                    rcopy($src . DIRECTORY_SEPARATOR . $file, 
                        $dst . DIRECTORY_SEPARATOR . $file);
                }
                else
                {
                    copy($src . DIRECTORY_SEPARATOR . $file, 
                        $dst . DIRECTORY_SEPARATOR . $file);
                }
            }
        }
        closedir($dir);
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
                    include($file_name);
                    $found = TRUE;
                }
            }

            // second attempt, try to look helpers in application path
            $file_name = APPPATH . 'helpers/' . $helper . '_helper.php';
            if(file_exists($file_name) && is_readable($file_name))
            {
                include($file_name);
                $found = TRUE;
            }

            // third attempt, try to look helpers in base path
            $file_name = BASEPATH . 'helpers/' . $helper . '_helper.php';
            if(file_exists($file_name) && is_readable($file_name))
            {
                include($file_name);
                $found = TRUE;
            }

        }
    }
}


if(!function_exists('view'))
{
    function view($view, $vars = array(), $return = FALSE)
    {
        $view = trim($view, '.php') . '.php';
        $view_parts = explode('/', $view);

        $found = FALSE;
        // is it on modules?
        if(count($view_parts) > 1)
        {
            $file_name = MODULEPATH . $view_parts[0] . '/views/' . implode('/', array_slice($view_parts, 1));
            if(file_exists($file_name) && is_readable($file_name)){
                $cached_file_name = VIEWPATH . 'modules/' . implode('/', $view_parts);

                // cache the file
                cache_file($file_name, $cached_file_name);

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
        $url_parts = explode('/', $url_parts[0]);

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
                    eval('$obj = new '.$namespace.'\\'.$test_class.'();');
                    if(method_exists($obj, $test_function)){
                        for($i=0; $i<count($test_parameters); $i++){
                            $test_parameters[$i] = "'" . addslashes($test_parameters[$i]) . "'";
                        }
                        $test_parameters = implode(', ', $test_parameters);
                        ob_start();
                        call_user_func(array($obj, $test_function), $test_parameters);
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

if(!function_exists('asset_url'))
{
    function asset_url($uri = '', $protocol = NULL)
    {
        $uri_parts = explode('/', $uri);
        if( count($uri_parts) > 1 && in_array($uri_parts[0], get_available_modules()) )
        {
            $module = $uri_parts[0];
            $path = implode(DIRECTORY_SEPARATOR, array_slice($uri_parts, 1));

            // get original file name and cached file name
            $original_file_name = MODULEPATH . $module . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $path;
            $cached_file_name = ASSETPATH . 'modules' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $path;

            cache_file($original_file_name, $cached_file_name);

            $uri = 'modules/' . $module . '/' . implode('/', array_slice($uri_parts, 1));
        }

        return get_instance()->config->asset_url($uri, $protocol);
    }
}

if(!function_exists('cache_module_assets'))
{
    function cache_module_assets($module)
    {
        if(in_array($module, get_available_modules()))
        {
            $original_path = MODULEPATH . $module . DIRECTORY_SEPARATOR . 'assets';
            if(file_exists($original_path))
            {
                rcopy($original_path, ASSETPATH . 'modules' . DIRECTORY_SEPARATOR . $module);
            }
        }
    }
}
