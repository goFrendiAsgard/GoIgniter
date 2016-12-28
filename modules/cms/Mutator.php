<?php // Independent class to change GoIgniter into No-CMS-2.0 by override extended config

namespace Modules\Cms;

class Mutator{

    private $_error_message;
    private $_mark_file;
    private $_welcome_controller_file;
    private $_ext_config_file;
    private $_ext_route_file;
    private $_backup_welcome_controller_file;
    private $_backup_ext_config_file;
    private $_backup_ext_route_file;

    public function __construct()
    {
        // define MODULEPATH, APPPATH & EXTCONFIGPATH if not defined
        defined('MODULEPATH') || define('MODULEPATH', dirname(__DIR__).'/');
        defined('APPPATH') || define('APPPATH', dirname(MODULEPATH).'/application/');
        defined('EXTCONFIGPATH') || define('EXTCONFIGPATH', APPPATH.'core/');

        // initiate all properties

        $this->_mark_file = MODULEPATH.'cms/.mutation';

        $this->_welcome_controller_file = APPPATH.'controllers/Welcome.php';
        $this->_ext_config_file = EXTCONFIGPATH.'config/config.php';
        $this->_ext_route_file = EXTCONFIGPATH.'config/routes.php';

        $this->_backup_welcome_controller_file = MODULEPATH.'cms/mutation_backup/Welcome.php.bak';
        $this->_backup_ext_config_file = MODULEPATH.'cms/mutation_backup/config.php.bak';
        $this->_backup_ext_route_file = MODULEPATH.'cms/mutation_backup/routes.php.bak';
    }

    public function get_error_message()
    {
        return $this->_error_message;
    }

    public function is_mutation_performed()
    {
        return file_exists($this->_mark_file);
    }

    private function copy_file($src, $dst)
    {
        if(file_exists($src) && is_readable($src))
        {
            if( (file_exists($dst) && is_writable($dst)) || (!file_exists($dst) && is_writable(dirname($dst))))
            {
                copy($src, $dst);
            }
        }
    }

    public function do_mutation()
    {
        if($this->is_mutation_performed())
        {
            $this->_error_message = 'Cannot do mutation, mutation has already performed';
            return FALSE;
        }

        // backup all the files
        $this->copy_file($this->_welcome_controller_file, $this->_backup_welcome_controller_file);
        $this->copy_file($this->_ext_config_file, $this->_backup_ext_config_file);
        $this->copy_file($this->_ext_route_file, $this->_backup_ext_route_file);

        // override config_file & route_file
        $this->copy_file(MODULEPATH.'cms/mutation_res/config.php', $this->_ext_config_file);
        $this->copy_file(MODULEPATH.'cms/mutation_res/routes.php', $this->_ext_route_file);

        // delete Welcome controller
        unlink($this->_welcome_controller_file);

        // set mark
        file_put_contents($this->_mark_file, 'Mutation performed on '.date('Y-m-d H:i:s'));
        return TRUE;
    }

    public function undo_mutation()
    {
        if(!$this->is_mutation_performed())
        {
            $this->_error_message = 'Cannot do mutation, mutation has not performed';
            return FALSE;
        }

        // put Welcome.php back
        $this->copy_file($this->_backup_welcome_controller_file, $this->_welcome_controller_file);

        // put ext config back
        if(!file_exists($this->_backup_ext_config_file))
        {
            unlink($this->_ext_config_file);
        }
        else
        {
            $this->copy_file($this->_backup_ext_config_file, $this->_ext_config_file);
        }

        // put ext route back
        if(!file_exists($this->_backup_ext_route_file))
        {
            unlink($this->_ext_route_file);
        }
        else
        {
            $this->copy_file($this->_backup_ext_route_file, $this->_ext_route_file);
        }

        // unset mark 
        unlink($this->_mark_file);
        return TRUE;
    }

}
