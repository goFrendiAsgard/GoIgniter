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
    protected  $_created_at      = 'created_at';
    protected  $_deleted_at      = 'deleted_at';
    protected  $_updated_at      = 'updated_at';
    protected  $_deleted         = 'deleted';
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
    protected function before_insert (&$success, &$error_message){}
    protected function after_insert  (&$success, &$error_message){}
    protected function before_update (&$success, &$error_message){}
    protected function after_update  (&$success, &$error_message){}
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
    public $_values = array();

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

        foreach($this->_parents as $alias=>$config)
        {
            $foreign_key = $config['foreign_key'];
            if(!in_array($foreign_key, $columns))
            {
                $columns[] = $foreign_key;
            }
        }

        $this->_allowed_columns = $columns;
    }

    protected function _data_to_entity(&$data, $class)
    {
        $Go_Model = 'Go_Model';

        // if it is already instance of the class
        if($data instanceof $class)
        {
            return $data;
        }
        // if it is instance of Go_Model
        else if($data instanceof $Go_Model)
        {
            $data = $data->as_array();
        }
        // array and other datatype
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
            if(array_key_exists($key, $this->_parents))
            {
                if(!array_key_exists($key, $this->_values) || $this->_values[$key] == NULL)
                {
                    // get parent's config
                    $config = $this->_parents[$key];
                    $class = $config['model'];
                    $foreign_key = $config['foreign_key'];

                    // if foreign key is set, then try to retrieve from database
                    if(array_key_exists($foreign_key, $this->_values) && $this->_values[$foreign_key] != NULL)
                    {
                        $real_parent = $class::find_by_id($this->_values[$foreign_key]);
                        if($real_parent != NULL)
                        {
                            $this->_set_parent($key, $real_parent);
                        }
                    }
                }
            }
            else if(array_key_exists($key, $this->_children))
            {
            }

            // get from _values
            if(array_key_exists($key, $this->_values))
            {
                $return =& $this->_values[$key];
                return $return;
            }
            return NULL;
        }
        return parent::__get($key);
    }

    public function _set_parent($relation_name, &$val)
    {
        // get parent's class name and foreign key from this table to parent
        $relation_config = $this->_parents[$relation_name];
        $class_name = $relation_config['model'];
        $foreign_key = $relation_config['foreign_key'];

        // create parent if not exist, or just simply return this val
        $parent = $this->_data_to_entity($val, $class_name);

        // look for parent's children configuration refering to this model
        $parent_config = $parent->_get_config(); 
        foreach($parent_config['children'] as $alias => $config)
        {
            // if it is the correct configuration, add this model as parent's child
            if($config['model'] == $class_name && $config['foreign_key'] == $foreign_key)
            {
                $parent_children = $parent->__get($alias);
                // if is exists don't need to do anything. This is also the recursive breaker
                if(!in_array($this, $parent_children))
                {
                    $parent->_values[$alias][] = &$this;
                }
                break;
            }
        }

        // finally after parent's value has been altered as necessary add parent's reference to this model
        $this->_values[$relation_name] = &$parent;
        $this->_values[$foreign_key] = $parent->_get_id();
    }

    public function __set($key, $val)
    {
        if(in_array($key, $this->_allowed_columns))
        {
            $current_pk = $this->_get_id();

            // children 
            if(array_key_exists($key, $this->_children))
            {
                // assigned a new column, then this must be empty first 
                $this->_values[$key] = array();
                $relation_config = $this->_children[$key];
                $class_name = $relation_config['model'];
                $foreign_key = $relation_config['foreign_key'];

                $child_config = $class_name::_get_static_config();
                $child_parent_config = $child_config['parents'];
                $true_config_found = FALSE;
                foreach($child_parent_config as $alias=>$config)
                {
                    if($config['model'] == $class_name && $config['foreign_key'] == $foreign_key)
                    {
                        foreach($val as $child_data)
                        {
                            $new_child = $this->_data_to_entity($child_data, $class_name);
                            $new_child->_set_parent($alias, $this);
                        }
                        $true_config_found = TRUE;
                        break;
                    }
                }

                if(!$true_config_found)
                {
                    foreach($val as $child_data)
                    {
                        $new_child = $this->_data_to_entity($child_data, $class_name);
                        $this->_values[$key][] = $new_child;
                    }
                }
            }

            // parents 
            else if(array_key_exists($key, $this->_parents))
            {
                $this->_set_parent($key, $val);
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
            'deleted' => $this->deleted,
            'columns' => $this->_columns,
            'children' => $this->_children,
            'parents' => $this->_parents,
        );
    }

    protected function _sanitize_properties()
    {
        // automatically set _table if not exists
        if(empty($this->_table))
        {
            $this->_table = get_called_class();
        }

        // check the actual field on the database
        if(!$this->_db->table_exists($this->_table))
        {
            show_error('Table '.$this->_table.' is not exists');
        }

        if(count($this->_columns) == 0  || !empty($this->_id) || !empty($this->_deleted) || !empty($this->_created_at) || !empty($this->_updated_at) || !empty($this->_deleted_at) || count($this->_parent) > 0)
        {
            // get field list
            $field_list = $this->_db->list_fields($this->_table);

            // add normal fields in field_list into $this->_columns.
            if(count($this->_columns) == 0)
            {
                foreach($field_list as $field)
                {
                    if($field == $this->_id || $field == $this->_deleted || $field == $this->_created_at || $field == $this->_updated_at || $field == $this->_deleted_at)
                    {
                        continue;
                    }
                    $this->_columns[] = $field;
                }
            }

            // if _id is not exist, try to guess it, then raise error
            if(!empty($this->_id) && !in_array($this->_id, $field_list))
            {
                $field_data_list = $this->db->field_data($this->_table);
                $new_id_set = FALSE;
                foreach ($field_data_list as $field_data)
                {
                    if($field_data->primary_key)
                    {
                        $this->_id = $field_data->name;
                        $new_id_set = TRUE;
                        break;
                    }
                }

                if(!$new_id_set)
                {
                    show_error('Field '.$this->_id.' not found in '.$this->_table);
                }
            }

            // remove invalid parent
            foreach($this->_parents as $alias => $parent_config)
            {
                if(!isset($parent_config['foreign_key']) || !isset($parent_config['model']) || !in_array($parent_config['foreign_key'], $field_list))
                {
                    unset($this->_parent[$alias]);
                }
            }

            // if special fields are not exist then delete it
            foreach(array('_deleted', '_created_at', '_updated_at', '_deleted_at') as $property)
            {
                if(!empty($this->$property) && !in_array($this->$property, $field_list))
                {
                    $this->$property = '';
                }
            }
        }

        // remove or repair invalid children
        foreach($this->_children as $alias => &$children_config)
        {
            if(!isset($children_config['foreign_key']) || !isset($children_config['model']))
            {
                unset($this->_children[$alias]);
            }
            else
            {
                // fix on_delete
                if(!isset($children_config['on_delete']) || !in_array($children_config['on_delete'], array('restrict', 'set_null', 'cascade')))
                {
                    $children_config['on_delete'] = 'restrict';
                }

                // fix on_purge
                if(!isset($children_config['on_purge']) || !in_array($children_config['on_purge'], array('restrict', 'set_null', 'cascade')))
                {
                    $children_config['on_purge'] = $children_config['on_delete'];
                }
            }

        }


        // assign default values for fields if values set from properties and not started with '_'
        foreach($this->_allowed_columns as $col)
        {
            if(strpos($col, '_')!== 0 && isset($this->$col))
            {
                $this->__set($col, $this->$col);
                unset($this->$col);
            }
        }

    }

    public function __construct($obj=array(), &$db = NULL)
    {
        // database
        $this->_set_allowed_columns();
        if($db != NULL)
        {
            $this->_db = $db;
        }
        else
        {
            $this->load->database();
            $this->_db = $this->db;
            $db = $this->db;
        }

        $this->_sanitize_properties();

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

        // get table, pk, and data
        $table = $this->_table;
        $pk_field = $this->_id;
        $pk = $this->_get_id();

        // start transaction
        $this->_db->trans_start();

        // is this old_record?
        $is_old_record = $pk != NULL;
        if(!$is_old_record)
        {
            $record_count = $this->_db->select('*')
                ->from($table)
                ->where($pk_field, $pk)->get()
                ->num_rows();
            $is_old_record = $record_count > 0;
        }

        // before update or before insert
        if($is_old_record)
        {
            $this->before_update($success, $error_message);
        }
        else
        {
            $this->before_insert($success, $error_message);
        }

        if($success)
        {
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
                    // turn to array
                    $simple_array = $this->as_array(TRUE);

                    // if is_old_record, then update, otherwise insert. Add timestamp as needed
                    if($is_old_record)
                    {
                        if($this->_updated_at != '')
                        {
                            $simple_array[$this->_updated_at] = $timestamp;
                            $this->__set($this->_updated_at, $timestamp);
                        }
                        if($this->_deleted != '')
                        {
                            $simple_array[$this->_deleted] = FALSE;
                            $this->__set($this->_deleted, FALSE);
                        }
                        $this->_db->update($table, $simple_array, array($pk_field=>$pk));
                    }
                    else
                    {
                        // add timestamp and default _deleted value
                        if($this->_created_at != '')
                        {
                            $simple_array[$this->_created_at] = $timestamp;
                            $this->__set($this->_created_at, $timestamp);
                        }
                        if($this->_deleted != '')
                        {
                            $simple_array[$this->_deleted] = FALSE;
                            $this->__set($this->_deleted, FALSE);
                        }
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
                            // after update or after insert
                            if($is_old_record)
                            {
                                $this->after_update($success, $error_message);
                            }
                            else
                            {
                                $this->after_insert($success, $error_message);
                            }

                            // stop transaction
                            if($success)
                            {
                                $this->_db->trans_complete();
                            }
                        }
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
        if($this->_deleted == '')
        {
            return $this->_do_purge($success, $error_message, $propagate);
        }
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
            if($this->_deleted_at != '')
            {
                $simple_array[$this->_deleted_at] = $timestamp;
                $this->__set($this->_deleted_at, $timestamp);
            }
            if($this->_deleted != '')
            {
                $simple_array[$this->_deleted] = TRUE;
                $this->__set($this->_deleted, TRUE);
            }
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

    ////////////////////////////////////////////////////////////////
    //
    // Static properties and methods 
    //
    ////////////////////////////////////////////////////////////////

    // all configurations should live here
    protected static $_configs;

    protected static function _get_static_config()
    {
        $class = get_called_class();

        // create self::$_configs if not exists
        if(!isset(self::$_configs))
        {
            self::$_configs = array();
        }

        // if self::$_configs contains configuration of this class, then get it, otherwise create one
        if(isset(self::$_configs) && array_key_exists($class, self::$_configs))
        {
            $config = self::$_configs[$class];
        }
        else
        {
            $db = NULL;
            $instance = new $class(array(), $db);
            $config = $instance->_get_config();
            unset($instance);

            $config['class'] = $class;
            $config['default_db'] = $db;
            self::$_configs[$class] = $config;
        }

        // return the configuration
        return self::$_configs[$class];
    }

    public static function find_by_id($id, &$db = NULL)
    {
        // init db and get config
        $config = static::_get_static_config();
        $class = $config['class'];
        if($db == NULL)
        {
            $db = $config['default_db'];
        }
        $table = $config['table'];
        $id_field = $config['id'];

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
        // init db and get config
        $config = static::_get_static_config();
        $class = $config['class'];
        if($db == NULL)
        {
            $db = $config['default_db'];
        }
        $table = $config['table'];
        $id_field = $config['id'];

        // prepare query
        $query = $db->select('*')
            ->from($table)
            ->limit($limit, $offset);

        if($config['deleted'] != '')
        {
            $query = $query->where($config['deleted'], FALSE);
        }

        $result = static::find_by_query($query);
        return $result;
    }

    public static function find_where($key, $value = NULL, $escape = NULL, $db = NULL)
    {
        // init db and get config
        $config = static::_get_static_config();
        $class = $config['class'];
        if($db == NULL)
        {
            $db = $config['default_db'];
        }
        $table = $config['table'];
        $id_field = $config['id'];

        // prepare query
        $query = $db->select('*')
            ->from($table)
            ->limit($limit, $offset);

        $result = static::find_by_query($query);
        return $result;
    }

    public static function find_by_query($query)
    {
        // get class name 
        $config = static::_get_static_config();
        $class = $config['class'];
        
        // execute query
        if(is_string($query))
        {
            $db = $config['default_db'];
            $query = $db->query($query);
        }
        else if(method_exists($query, 'get'))
        {
            $query = $query->get();
        }

        // run query and parse the result
        $return = array();
        foreach($query->result_array() as $row)
        {
            $return[] = new $class($row, $db);
        }
        return $return;
    }

}
