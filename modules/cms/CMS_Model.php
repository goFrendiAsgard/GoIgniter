<?php
namespace Modules\Cms;
use \Go_Model;

abstract class CMS_Model extends Go_Model
{
    protected $_created_by = 'created_by';
    protected $_updated_by = 'updated_by';
    protected $_deleted_by = 'deleted_by';
    protected $_site_id    = 'site_id';
    protected $_user_model = '\Modules\Cms\User_Model';
    protected $_site_model = '\Modules\Cms\Site_Model';

    public function __construct($obj=array(), $db = NULL)
    {
        parent::__construct($obj, $db);

        foreach(array($this->_created_by, $this->_updated_by, $this->_deleted_by, $this->_site_id) as $column)
        {
            if($column != '')
            {
                $this->_columns[] = $column;
            }
        }

        if($this->_user_model != '')
        {
            if($this->_created_by != '')
            {
                $this->_parents['creator'] = array(
                    'model' => $this->_user_model,
                    'foreign_key' => $this->_created_by,
                );
            }
            if($this->_updated_by != '')
            {
                $this->_parents['updater'] = array(
                    'model' => $this->_user_model,
                    'foreign_key' => $this->_updated_by,
                );
            }
            if($this->_deleted_by != '')
            {
                $this->_parents['deleter'] = array(
                    'model' => $this->_user_model,
                    'foreign_key' => $this->_deleted_by,
                );
            }
        }

        if($this->_site_model != '')
        {
            $this->_parents['site'] = array(
                'model' => $this->_site_model,
                'foreign_key' => $this->_site_id,
            );
        }

        $allowed_columns = parent::_set_allowed_columns();

    }

    protected function _add_default_site()
    {
        if($this->_site_id != '' && $this->_site_model != '')
        {
            if($this->__get('site') === NULL)
            {
                $current_site =& $this->_site_model::get_current_site();
                $this->__set('site', $current_site);
            }
        }
    }

    public function before_insert(&$success, &$message)
    {
        if($this->_created_by != '' && $this->_user_model != '')
        {
            if($this->__get('creator') === NULL)
            {
                $current_user = $this->_user_model::get_current_user();
                $this->__set('creator', $current_user);
            }
        }
        $this->_add_default_site;
    }

    public function before_update(&$success, &$message)
    {
        if($this->_updated_by != '' && $this->_user_model != '')
        {
            if($this->__get('updater') === NULL)
            {
                $current_user = $this->_user_model::get_current_user();
                $this->__set('updater', $current_user);
            }
        }
        $this->_add_default_site;
    }

    public function before_delete(&$success, &$message)
    {
        if($this->_deleted_by != '' && $this->_user_model != '')
        {
            if($this->__get('deleter') === NULL)
            {
                $current_user =& $this->_user_model::get_current_user();
                $this->__set('deleter', $current_user);
            }
        }
    }

    public function _get_config()
    {
        $config = parent::_get_config();
        $config['created_by'] = $this->_created_by;
        $config['updated_by'] = $this->_updated_by;
        $config['deleted_by'] = $this->_deleted_by;
        $config['site_id'] = $this->_site_id;
        $config['user_model'] = $this->_user_model;
        $config['site_model'] = $this->_site_model;
        return $config;
    }

    public static function find_by_current_site()
    {
        $config = static::_get_static_config();
        if($config['site_id'] != '' && $config['site_model'] != '')
        {
            $site_model = $config['site_model'];
            $site =& $site_model::get_current_site();

            if($site != NULL)
            {
                $site_model_config = $site->_get_config();
                $pk_field = $site_model_config['id'];

                $site_id = $site->$pk_field;

                $where = array('deleted' => FALSE, $config['site_id'] => $site_id);
                return static::find_where($where);
            }
        }

        return static::find_all();
    }
}
