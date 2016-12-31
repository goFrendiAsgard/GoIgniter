<?php
class Mutation_maker
{
    public $description = "";

    public $parameter = "[module_path [app_path]]";

    protected function get_mutator($arguments = array()){
        $module_path = get_array_value($arguments, 0, '');
        $app_path = get_array_value($arguments, 1, '');

        // define constants if necessary
        $module_path == '' || define('MODULEPATH', $module_path);
        $app_path == '' || (define('APPPATH', $app_path) && define(EXTCONFIGPATH, APPPATH.'core/'));

        // import mutator
        if(defined('MODULEPATH'))
        {
            require_once(MODULEPATH.'/cms/Mutator.php');
        }
        else
        {
            require_once(dirname(dirname(__DIR__)).'/modules/cms/Mutator.php');
        }

        // do mutation
        $mutator = new \Modules\Cms\Mutator();
        return $mutator;
    }

}
