<?php
namespace Modules\Cms;
use \Modules\Cms\CMS_Model;

class User_Model extends CMS_Model 
{
    protected $_table      = 'cms_user';
    protected $_site_id    = '';
    protected $_site_model = '';
    protected $_columns    = ['user_name', 'hashed_password', 'email'];
    protected $_unique_columns = ['user_name'];

    public function __set($key, $val)
    {
        if($key == 'password')
        {
            parent::__set('hashed_password', User_Model::hash($val));
        }
        else
        {
            parent::__set($key, $val);
        }
    }

    public static function get_current_user()
    {
        if(isset($_SESSION['user_id']))
        {
            return User_Model::find_by_id($_SESSION['user_id']);
        }
    }

    public static function logout()
    {
        unset($_SESSION['user_id']);
    }

    public static function login($user_name, $password)
    {
        $user = User_Model::find_where(array(
            'user_name' => $user_name, 
            'hashed_password' => static::hash($password)
        ));
    }

    public static function hash($password)
    {
        //$this->config->load();
        //$salt = $this->config->config['encryption_key'];
        $salt = 'abc';
        return crypt($password, $salt);
    }

}
