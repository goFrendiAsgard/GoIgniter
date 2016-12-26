<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This was created by cms module's Genesis 
$_cms_config_file = MODULEPATH.'cms/json/configuration.json';
if(file_exists($_cms_config_file))
{
    $_json = file_get_contents($_cms_config_file);
    $_cms_config = json_decode($_json, TRUE);
    foreach($_cms_config as $key=>$val)
    {
        $config[$key] = $val;
    }
}
