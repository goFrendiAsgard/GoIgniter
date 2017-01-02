<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Go_Model extends CI_Model
{
    ////////////////////////////////////////////////////////////////
    //
    // Generally overidden properties and methods
    //
    ////////////////////////////////////////////////////////////////

    protected  $_table           = '';
    protected  $_id              = 'id';
    protected  $_created_at      = '_created_at';
    protected  $_deleted_at      = '_deleted_at';
    protected  $_updated_at      = '_updated_at';
    protected  $_deleted         = '_deleted';
    protected  $_columns         = array();
    
    // array of associative array. Each child should has these keys:
    // "model", "foreign_key", "on_delete", and "on_purge".
    // on_delete & on_purge can be "restrict", "cascade", and "set_null"
    protected  $_children        = array();

    // array of associative array. Each child should has these keys:
    // "model", "foreign_key", "on_delete".
    protected  $_parents         = array();

    protected function before_save   (&$success, &$error_message){}
    protected function after_save    (&$success, &$error_message){}
    protected function before_delete (&$success, &$error_message){}
    protected function after_delete  (&$success, &$error_message){}
    protected function before_purge  (&$success, &$error_message){}
    protected function after_purge   (&$success, &$error_message){}

    ////////////////////////////////////////////////////////////////
    //
    // Internally used properties and methods.
    // Don't override unless you know exactly what they do
    //
    ////////////////////////////////////////////////////////////////

    protected $_allowed_columns = array();
    protected $_db = NULL;
    protected $_values = array();

    protected function _set_allowed_columns()
    {
        $columns = $this->_columns;

        // get default columns
        $default_columns = array($this->_id, $this->_created_at, 
            $this->_updated_at, $this->_deleted_at, $this->_deleted);
        $default_columns = array_merge($default_columns, array_keys($this->_parents));
        $default_columns = array_merge($default_columns, array_keys($this->_children));

        // add default_column to columns
        foreach($default_columns as $default_column)
        {
            if($default_column != '')
            {
                $columns[] = $default_column;
            }
        }

        $this->_allowed_columns = $columns;
    }

    protected function _data_to_entity($data, $class)
    {
        $this_class_name = 'Go_Model';
        if($data instanceof $class)
        {
            return $data;
        }
        else if($data instanceof $this_class_name)
        {
            $this_class = $this_class_name;
            $data = $data->as_array();
        }
        else
        {
            $data = (array) $data;
        }
        return new $class($data, $this->_db);
    }

    public function __get($key)
    {
        if(in_array($key, $this->_allowed_columns))
        {
            
            // get from _values
            if(array_key_exists($key, $this->_values))
            {
                return $this->_values[$key];
            }
            else
            {
                // if parent requested
                if(array_key_exists($key, $this->_parents))
                {

                }

                // if child requested
                else if(array_key_exists($key, $this->_children))
                {
                    if($this->__get($this->_id) != NULL)
                    {
                        // TODO: get from database and merge it with _values
                    }
                }

                return NULL;
            }
        }
        return parent::__get($key);
    }

    public function __set($key, $val)
    {
        if(in_array($key, $this->_allowed_columns))
        {
            $current_pk = $this->__get($this->_id);

            // children 
            if(array_key_exists($key, $this->_children))
            {
                // assigned a new column, then this must be empty first 
                $this->_values[$key] = array();
                $child_config = $this->_children[$key];
                $class_name = $child_config['model'];

                foreach($val as $child_data)
                {
                    $new_child = $this->_data_to_entity($child_data, $class_name);
                    $this->_values[$key][] = $new_child;
                }
            }
            // parents 
            else if(array_key_exists($key, $this->_parents))
            {
                $parent_config = $this->_parents[$key];
                $class_name = $parent_config['model'];
                $parent = $this->_data_to_entity($val, $class_name);
                $this->_values[$key] = $parent;
            }
            // true columns
            else
            {
                $this->_values[$key] = $val;
            }
        }
    }

    public function _get_id()
    {
        return $this->__get($this->_id);
    }

    public function _get_config()
    {
        return array(
            'table' => $this->_table,
            'id' => $this->_id,
            'created_at' => $this->_created_at,
            'deleted_at' => $this->_deleted_at,
            'updated_at' => $this->_updated_at,
            'deleted_at' => $this->_deleted_at,
            'columns' => $this->_columns,
            'children' => $this->_children,
            'parents' => $this->_parents,
        );
    }

    public function __construct($obj=array(), &$db = NULL)
    {
        // database
        $this->_set_allowed_columns();
        if($this->_db != NULL)
        {
            $this->_db = $db;
        }
        else
        {
            $this->load->database();
            $this->_db = $this->db;
            $db = $this->_db;
        }

        // create properties
        foreach($obj as $key=>$val)
        {
            $this->__set($key, $val);
        }

        // on creation, children should be empty array if not defined
        foreach(array_keys($this->_children) as $key)
        {
            if(!array_key_exists($key, $this->_values))
            {
                $this->_values[$key] = array();
            }
        }
    }

    // return array representation of $this->_values
    public function as_array($minimal = FALSE)
    {
        $array = array();
        foreach($this->_values as $key => $val)
        {
            if(!in_array($key, $this->_allowed_columns))
            {
                continue;
            }

            // children 
            if(!$minimal && array_key_exists($key, $this->_children))
            {
                $array[$key] = array();
                foreach($val as $child_data)
                {
                    $array[$key][] = $child_data->as_array(TRUE);
                }
            }
            // parents 
            else if(!$minimal && array_key_exists($key, $this->_parents))
            {
                $array[$key] = $val->as_array(TRUE);
            }
            // true columns
            else if(!array_key_exists($key, $this->_children) && !array_key_exists($key, $this->_parents))
            {
                $array[$key] = $val;
            }
        }
        return $array;
    }

    // save this record
    public function save()
    {
        $this->_do_save();
    }

    // $success and $error_message are passed for every before and after events
    // $propagate inform whether it is needed to update parent & children as well
    public function _do_save(&$success = TRUE, &$error_message = '', $propagate = TRUE)
    {
        $timestamp = date('Y-m-d H:i:s');

        // start transaction
        $this->_db->trans_start();

        // before save
        $this->before_save($success, $error_message);
        if($success)
        {
            // save parents
            if($propagate)
            {
                foreach($this->_parents as $alias=>$parent_config)
                {
                    // skip if parent is NULL
                    $parent = $this->__get($alias);
                    if($parent == NULL){ continue; }

                    // get foreign key and save
                    $parent->_do_save($success, $error_message, FALSE, TRUE);
                    if(!$success)
                    {
                        break;
                    }

                    // update foreign key and reference to this field
                    $fk = $parent_config['foreign_key'];    
                    $parent_pk = $parent->_get_id();
                    $this->__set($fk, $parent_pk);
                    $this->__set($alias, $parent);
                }
            }

            if($success)
            {
                // get table, pk, and data
                $table = $this->_table;
                $pk_field = $this->_id;
                $pk = $this->_get_id();
                $simple_array = $this->as_array(TRUE);

                // if $pk exists, then update, otherwise insert. Add timestamp as needed
                if($pk !== NULL)
                {
                    $simple_array[$this->_updated_at] = $timestamp;
                    $this->set($this->_updated_at, $timestamp);
                    $this->_db->update($table, $simple_array, array($pk_field=>$pk));
                }
                else
                {
                    // add timestamp and default _deleted value
                    $simple_array[$this->_created_at] = $timestamp;
                    $this->__set($this->_created_at, $timestamp);
                    $simple_array[$this->_deleted] = FALSE;
                    $this->__set($this->_deleted, FALSE);
                    // insert
                    $this->_db->insert($table, $simple_array);
                    $pk = $this->_db->insert_id();
                    $this->__set($pk_field, $pk);
                }

                // update foreign keys of children
                if($propagate)
                {
                    foreach($this->_children as $alias=>$child_config)
                    {
                        $fk = $child_config['foreign_key'];    
                        $children = $this->__get($alias);
                        $new_children = array();
                        foreach($children as $child)
                        {
                            // set foreign key and save
                            $child->__set($fk, $pk);
                            $child->_do_save($success, $error_message, FALSE);
                            $new_children[] = $child;
                            if(!$success)
                            {
                                break;
                            }
                        }
                        $this->__set($alias, $new_children);
                    }
                }

                if($success)
                {
                    $this->after_save($success, $error_message);
                    if($success)
                    {
                        // stop transaction
                        $this->_db->trans_complete();
                    }
                }
            }
        }

        // don't put this in else, because when $success is TRUE 
        // other evaluations will be performed, and $success might
        // be changed 
        if(!$success)
        {
            $this->_db->trans_rollback();
        }

        return array('success' => $success, 'error_message' => $error_message);
    }

    // soft delete this record
    public function delete()
    {
        $this->_do_delete();
    }

    // $success and $error_message are passed for every before and after events
    // $propagate inform whether it is needed to update parent & children as well
    public function _do_delete(&$success = TRUE, &$error_message = '', $propagate = TRUE)
    {
        // get table, pk, pk_field, and timestamp
        $table = $this->_table;
        $pk_field = $this->_id;
        $pk = $this->_get_id();

        if($pk === NULL)
        {
            return array('success' => FALSE, $error_message = 'Deletion cannot be performed. Primary Key is not defined');
        }

        $timestamp = date('Y-m-d H:i:s');

        // start transaction
        $this->_db->trans_start();

        // before delete
        $this->before_delete($success, $error_message);
        if($success)
        {
            // get data
            $simple_array = $this->as_array(TRUE);

            // add timestamp, and update deleted
            $simple_array[$this->_deleted_at] = $timestamp;
            $this->__set($this->_deleted_at, $timestamp);
            $simple_array[$this->_deleted] = TRUE;
            $this->__set($this->_deleted, TRUE);
            $this->_db->update($table, $simple_array, array($pk_field=>$pk));

            // update foreign keys of children
            if($propagate)
            {
                foreach($this->_children as $alias=>$child_config)
                {
                    $fk = $child_config['foreign_key'];    
                    $on_delete = $child_config['on_delete'];
                    $children = $this->__get($alias);
                    $new_children = array();

                    // set foreign key and delete
                    switch($on_delete)
                    {
                        case 'set_null' :
                            foreach($children as $child)
                            {
                                $child->__set($fk, NULL);
                                $child->_do_save($success, $error_message, FALSE);
                                $new_child[] = $child;
                            }
                            $this->__set($alias, $new_children);
                            break;

                        case 'cascade'  :
                            foreach($children as $child)
                            {
                                $child->__set($fk, $pk);
                                $child->_do_delete($success, $error_message, FALSE);
                                $new_child[] = $child;
                            }
                            $this->__set($alias, $new_children);
                            break;

                        case 'restrict' :
                        default :
                            foreach($children as $child)
                            {
                                $success = FALSE;
                                $error_message = 'Deletion cannot be performed. There is a ' . $alias . ' in database';
                                break;
                            }
                    }

                    if(!$success)
                    {
                        break;
                    }
                }
            }

            if($success)
            {
                $this->after_delete($success, $error_message);
                if($success)
                {
                    // stop transaction
                    $this->_db->trans_complete();
                }
            }
        }

        // don't put this in else, because when $success is TRUE 
        // other evaluations will be performed, and $success might
        // be changed 
        if(!$success)
        {
            $this->_db->trans_rollback();
        }

        return array('success' => $success, 'error_message' => $error_message);
    }

    public function purge()
    {
        $this->_do_purge();
    }
    // $success and $error_message are passed for every before and after events
    // $propagate inform whether it is needed to update parent & children as well
    public function _do_purge(&$success = TRUE, &$error_message = '', $propagate = TRUE)
    {
        // get table, pk, pk_field, and timestamp
        $table = $this->_table;
        $pk_field = $this->_id;
        $pk = $this->_get_id();

        if($pk === NULL)
        {
            return array('success' => FALSE, $error_message = 'Purge Deletion cannot be performed. Primary Key is not defined');
        }

        $timestamp = date('Y-m-d H:i:s');

        // start transaction
        $this->_db->trans_start();

        // before purge
        $this->before_purge($success, $error_message);
        if($success)
        {
            // get data
            $simple_array = $this->as_array(TRUE);

            $this->_db->delete($table, array($pk_field=>$pk));

            // update foreign keys of children
            if($propagate)
            {
                foreach($this->_children as $alias=>$child_config)
                {
                    $fk = $child_config['foreign_key'];    
                    $on_purge = $child_config['on_purge'];
                    $children = $this->__get($alias);
                    $new_children = array();

                    // set foreign key and purge
                    switch($on_purge)
                    {
                        case 'set_null' :
                            foreach($children as $child)
                            {
                                $child->__set($fk, NULL);
                                $child->_do_save($success, $error_message, FALSE);
                                $new_child[] = $child;
                            }
                            $this->__set($alias, $new_children);
                            break;

                        case 'cascade'  :
                            foreach($children as $child)
                            {
                                $child->__set($fk, $pk);
                                $child->_do_purge($success, $error_message, FALSE);
                                $new_child[] = $child;
                            }
                            $this->__set($alias, $new_children);
                            break;

                        case 'restrict' :
                        default :
                            foreach($children as $child)
                            {
                                $success = FALSE;
                                $error_message = 'Purge Deletion cannot be performed. There is a ' . $alias . ' in database';
                                break;
                            }
                    }

                    if(!$success)
                    {
                        break;
                    }
                }
            }

            if($success)
            {
                $this->after_purge($success, $error_message);
                if($success)
                {
                    // stop transaction
                    $this->_db->trans_complete();
                }
            }
        }

        // don't put this in else, because when $success is TRUE 
        // other evaluations will be performed, and $success might
        // be changed 
        if(!$success)
        {
            $this->_db->trans_rollback();
        }

        return array('success' => $success, 'error_message' => $error_message);
     }

    protected static $_config_cached;
    protected static $_config;
    protected static function _get_static_config()
    {
        if(static::$_config_cached === TRUE)
        {
            return static::$_config;
        }

        $db = NULL;
        $class = get_called_class();
        $instance = new $class(array(), $db);
        $info = $instance->_get_config();
        unset($instance);

        $info['class'] = $class;
        $info['default_db'] = $db;
        static::$_config = $info;
        static::$_config_cached = TRUE;
        return static::$_config;
    }

    public static function find_by_id($id, &$db = NULL)
    {
        // init db and get info
        $info = static::_get_static_config();
        $class = $info['class'];
        if($db == NULL)
        {
            $db = $info['default_db'];
        }
        $table = $info['table'];
        $id_field = $info['id'];

        // prepare query
        $query = $db->select('*')
            ->from($table)
            ->where($id_field, $id);

        $result = static::find_by_query($query);
        if(count($result) > 0)
        {
            $row = $result[0];
            return $row;
        }
        return NULL;
    }

    public static function find_all($limit=1000, $offset=0, $db = NULL)
    {
        // init db and get info
        $info = static::_get_static_config();
        $class = $info['class'];
        if($db == NULL)
        {
            $db = $info['default_db'];
        }
        $table = $info['table'];
        $id_field = $info['id'];

        // prepare query
        $query = $db->select('*')
            ->from($table)
            ->limit($limit, $offset);

        $result = static::find_by_query($query);
        return $result;
    }

    public static function find_where($key, $value = NULL, $escape = NULL, $db = NULL)
    {
        // init db and get info
        $info = static::_get_static_config();
        $class = $info['class'];
        if($db == NULL)
        {
            $db = $info['default_db'];
        }
        $table = $info['table'];
        $id_field = $info['id'];

        // prepare query
        $query = $db->select('*')
            ->from($table)
            ->limit($limit, $offset);

        $result = static::find_by_query($query);
        return $result;
    }

    public static function find_by_query($query, $db = NULL)
    {
        // init db and get info
        $info = static::_get_static_config();
        $class = $info['class'];
        if($db == NULL)
        {
            $db = $info['default_db'];
        }
        $table = $info['table'];
        $id_field = $info['id'];

        // run query and parse the result
        $return = array();
        foreach($query->get()->result_array() as $row)
        {
            $return[] = new $class($row, $db);
        }
        return $return;
    }

}
