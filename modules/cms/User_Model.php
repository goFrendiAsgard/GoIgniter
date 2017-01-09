<?php
namespace Modules\Cms;
use \Modules\Cms\CMS_Model;

class User_Model extends CMS_Model 
{
    protected $_table      = 'cms_user';
    protected $_site_id    = '';
    protected $_site_model = '';
    protected $_columns    = ['user_name', 'hashed_password', 'api_session_code', 'email', 'first_name', 'last_name', 'birthday', 'profile_picture', 'description', 'last_login', 'active'];
    protected $_unique_columns = ['user_name'];

    public $active = TRUE; // default value

    public function set_password($val)
    {
        $this->hashed_password = User_Model::hash($val);
    }

    // generate new api session code and save it
    public function generate_new_session()
    {
        $this->api_session_code = User_Model::hash(date('Y-m-d H:i:s') . $this->user_name . rand(0,100));
        if($this->id != NULL)
        {
            $this->db->update($this->_table, 
                array('api_session_code' => $this->api_session_code),
                array('id' => $this->id)
            );
        }
    }

    // api session code should not be null.
    public function before_insert(&$success, &$error_message)
    {
        parent::before_insert($success, $error_message);
        if($this->api_session_code == NULL)
        {
            $this->generate_new_session();
        }
    }

    public static function get_current_user()
    {
        if(isset($_SESSION['user_id']))
        {
            return User_Model::find_by_id($_SESSION['user_id']);
        }
        return NULL;
    }

    public static function logout()
    {
        unset($_SESSION['user_id']);
    }

    public static function login($identity, $password = NULL)
    {
        // we can login by user_name, email, or api_session_code
        $user_list = array();
        $where_list = array(
            array('user_name' => $identity, 'hashed_password' => static::hash($password)),
            array('email' => $identity, 'hashed_password' => static::hash($password)),
            array('api_session_code' => $identity),
        );

        // check from each where condition
        foreach($where_list as $where)
        {
            $user_list = User_Model::find_where($where);
            if(count($user_list) > 0)
            {
                break;
            }
        }

        if(count($user_list) == 0)
        {
            return FALSE;
        }
        else
        {
            $user = $user_list[0];
            $user->last_login = date('Y-m-d H:i:s');
            $user->generate_new_session();
            $_SESSION['user_id'] = $user->id;
            return TRUE;
        }
    }

    public static function hash($password)
    {
        $CI =& get_instance();
        $salt = sha1($CI->config->config['encryption_key']);
        return sha1($password . $salt);
    }

}
