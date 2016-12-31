<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('__load_route_config'))
{
    function __load_route_config()
    {
        $route = array();

        if (file_exists(APPPATH.'config/routes.php'))
        {
            include(APPPATH.'config/routes.php');
        }

        if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/routes.php'))
        {
            include(APPPATH.'config/'.ENVIRONMENT.'/routes.php');
        }

        // Added by Go Frendi, to allow extra route modification
        if (file_exists(EXTCONFIGPATH.'config/routes.php'))
        {
            include(EXTCONFIGPATH.'config/routes.php');
        }

        return $route;
    }
}

if(!function_exists('__sanitize_route'))
{
    function __sanitize_route($route)
    {
        if (isset($route) && is_array($route))
        {
            unset($route['default_controller'], $route['translate_uri_dashes'], $route['disable_autoroute'], $route['404_override']);

            // Added by Go Frendi, to trick reserved keywords
            // so that http://localhost/default_controller will be directed to $route['_default_controller']
            $reserved_keywords = array('default_controller', 'translate_uri_dashes', 'disable_autoroute', '404_override');
            $new_route = array();
            foreach($route as $old_key=>$val)
            {
                $key_parts = explode('/', $old_key);
                if(count($key_parts) > 0)
                {
                    $first_segment = $key_parts[0];
                    if(!in_array($first_segment, $reserved_keywords) && in_array(ltrim($first_segment, '_'), $reserved_keywords))
                    {
                        $first_segment = substr($first_segment, 1);
                        $key_parts[0] = $first_segment;
                        $new_key = implode('/', $key_parts);

                        // create new key
                        $new_route[$new_key] = $val;
                        unset($route[$old_key]);
                    }
                }
            }
            $route = array_merge($new_route, $route);
            return $route;
        }
        return array();
    }
}
