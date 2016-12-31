<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Override default controller
$route['default_controller'] = 'cms/cms';


// Get configuration from json route configuration of cms module
$_cms_route_file = MODULEPATH.'cms/json/routes.json';
if(file_exists($_cms_route_file) && is_readable($_cms_route_file))
{
    $_json = file_get_contents($_cms_route_file);
    $_cms_config = json_decode($_json, TRUE);
    foreach($_cms_config as $key=>$val)
    {
        $route[$key] = $val;
    }
}


// Get configuration from per-site json route configuration of cms module
include_once(APPPATH.'core/Site.php');
$site = new Site();
$site_code = $site->get_current_code();
$_cms_route_file = $site->is_main_site()?
    MODULEPATH.'cms_/json/routes-main.json' :
    MODULEPATH.'cms/json/sites/routes-site-'.$site_code.'.json';
unset($site);

if(file_exists($_cms_route_file) && is_readable($_cms_route_file))
{
    $_json = file_get_contents($_cms_route_file);
    $_cms_config = json_decode($_json, TRUE);
    foreach($_cms_config as $key=>$val)
    {
        $route[$key] = $val;
    }
}
