<?php defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Go_Model extends CI_Model
{
    ////////////////////////////////////////////////////////////////
    //
    // Generally overidden properties and methods
    //
    ////////////////////////////////////////////////////////////////

    protected $_table             = '';
    protected $_id                = 'id';
    protected $_created_at        = 'created_at';
    protected $_deleted_at        = 'deleted_at';
    protected $_updated_at        = 'updated_at';
    protected $_deleted           = 'deleted';
    protected $_columns           = array();
    protected $_unique_columns    = array();
    protected $_turn_off_cache    = FALSE;
    
    // array of associative array. Each child should has these keys:
    // "model", "foreign_key", "on_delete", and "on_purge".
    // on_delete & on_purge can be "restrict", "cascade", and "set_null"
    protected $_children          = array();

    // array of associative array. Each child should has these keys:
    // "model", "foreign_key", "on_delete".
    protected $_parents           = array();

    // array of associative array. Each child should has these keys:
    // "pivot_model", "model", "backref_relation", "on_delete", and "on_purge".
    // on_delete & on_purge can be "restrict", "cascade", and "set_null"
    protected $_many_to_many      = array();

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
    // Don't override (even if it is public) 
    // unless you know exactly what they do
    //
    ////////////////////////////////////////////////////////////////

    public $_allowed_columns = array();
    public $_fetched_parents = array();
    public $_fetched_children = array();
    public $_values = array();
    public $_modified = TRUE; // by default, _modified flag is true
    public $_evaluated = FALSE; // only used in 'save' process, to mark whether this node is already evaluated or not

    protected function _get_real_pivot_child($relation_name)
    {
        return $relation_name.md5($relation_name);
    }

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

        // add parents to columns
        foreach($this->_parents as $alias=>$config)
        {
            $foreign_key = $config['foreign_key'];
            if(!in_array($foreign_key, $columns))
            {
                $columns[] = $foreign_key;
            }
        }

        // add many_to_many
        foreach(array_keys($this->_many_to_many) as $many_to_many)
        {
            if(!in_array($many_to_many, $columns))
            {
                $columns[] = $many_to_many;
            }
        }

        $this->_allowed_columns = $columns;
    }

    protected function _data_to_entity(&$data, $class)
    {
        if($data === NULL)
        {
            return NULL;
        }

        $Go_Model = 'Go_Model';
        $new_data = NULL;

        // if it is already instance of the class
        if($data instanceof $class)
        {
            return $data;
        }
        // if it is instance of Go_Model
        else if($data instanceof $Go_Model)
        {
            $new_data = $data->as_array();
        }
        // array and other datatype
        else if(!is_string($data))
        {
            $new_data = (array) $data;
        }

        return new $class($new_data, $this->db);
    }

    public function __call($method, $parameter)
    {
        $mode = NULL;
        $accessed_relation = NULL;
        $child_type = NULL;

        // determine mode and relation
        if(substr($method, 0, 4) == 'add_')
        {
            $mode = 'add';
            $accessed_relation = substr($method, 4);
        }
        else if(substr($method, 0, 7) == 'remove_')
        {
            $mode = 'remove';
            $accessed_relation = substr($method, 7);
        }

        // determine child type
        if(array_key_exists($accessed_relation, $this->_children))
        {
            $child_type = 'one_to_many';
        }
        else if(array_key_exists($accessed_relation, $this->_many_to_many))
        {
            $child_type = 'many_to_many';
        }

        // do the real action
        if(in_array($child_type, array('one_to_many', 'many_to_many')) && in_array($mode, array('add', 'remove')) && count($parameter) > 0)
        {
            if($child_type == 'one_to_many')
            {
                // get other config
                $accessed_relation_config = $this->_children[$accessed_relation];
                $class_name = $accessed_relation_config['model'];
                $backref_relation = $this->_get_backref_relation($accessed_relation);
                $child = $this->_data_to_entity($parameter[0], $class_name);

                // real action, add or remove
                if($mode == 'add')
                {
                    $child->_set_parent($backref_relation, $this);
                }
                else if($mode == 'remove')
                {
                    $child->_unset_parent($backref_relation);
                    if($child->_get_id() != NULL)
                    {
                        $child->save();
                    }
                }
            }
            else if($child_type == 'many_to_many')
            {
                // get real children
                $child_key = $this->_get_real_pivot_child($accessed_relation);
                $children = $this->__get($child_key);

                // get the config
                $many_to_many_config = $this->_many_to_many[$accessed_relation];
                $relation = $many_to_many_config['relation'];
                $backref_relation = $many_to_many_config['backref_relation'];
                $pivot_class = $many_to_many_config['pivot_model'];
                $pivot_config = $pivot_class::_get_static_config();
                $virtual_child_class = $pivot_config['parents'][$relation]['model'];

                $virtual_child = $this->_data_to_entity($parameter[0], $virtual_child_class);

                if($mode == 'add')
                {
                    $child = new $pivot_class();
                    $child->_set_parent($relation, $virtual_child);
                    $child->_set_parent($backref_relation, $this);
                }
                else if($mode == 'remove')
                {
                    foreach($this->__get($child_key) as $child)
                    {
                        if($child->__get($relation) == $virtual_child)
                        {
                            $child->_unset_parent($backref_relation);
                            $child->_unset_parent($relation);
                            if($child->_get_id() != NULL)
                            {
                                $child->delete();
                            }
                            break;
                        }
                    }
                }
            }

        }

    }

    public function __get($key)
    {
        if(method_exists($this, 'get_'.$key))
        {
            call_user_func_array(array($this, 'get_'.$key), array());
        }
        else if(in_array($key, $this->_allowed_columns))
        {
            // fetch parent & children is expensive, don't do it if not necessary
            if(array_key_exists($key, $this->_parents) && !in_array($key, $this->_fetched_parents))
            {
                // Lazy loading parent in case of foreign key defined
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
                            // save old modification flag
                            $modified = $this->_modified;
                            $parent_modified = $real_parent->_modified;

                            // build relationship
                            $this->_set_parent($key, $real_parent);

                            // set modification flag
                            $this->_modified = $modified;
                            $real_parent->_modified = $parent_modified;
                        }
                    }
                }

                // save fetched state
                $this->_fetched_parents[] = $key;
            }
            else if(array_key_exists($key, $this->_children) && !in_array($key, $this->_fetched_children) && $this->_get_id() != NULL)
            {
                // get child's config
                $config = $this->_children[$key];
                $class = $config['model'];
                $foreign_key = $config['foreign_key'];

                $child_config = $class::_get_static_config();
                foreach($child_config['parents'] as $alias=>$child_parent_config)
                {
                    // this is the correct child config
                    if($child_parent_config['model'] == get_called_class() && $child_parent_config['foreign_key'] == $foreign_key)
                    {
                        // get child list
                        $where = array($foreign_key => $this->_get_id());
                        if($child_config['deleted'] != '')
                        {
                            $where[$child_config['deleted']] = FALSE;
                        }
                        $real_child_list = $class::find_where($where);

                        // get for current children's id list
                        $current_children_id_list = array();
                        $child_pk = $child_config['id'];
                        foreach($this->_values[$key] as $child)
                        {
                            if(array_key_exists($child_pk, $child->_values))
                            {
                                $current_children_id_list[] = $child->_values[$child_pk];
                            }
                        }

                        foreach($real_child_list as &$real_child)
                        {
                            if($real_child === NULL)
                            {
                                continue;
                            }
                            if(!in_array($real_child->_values[$child_pk], $current_children_id_list))
                            {
                                // save old modification flag
                                $modified = $this->_modified;
                                $child_modified = $real_child->_modified;

                                // build relationship
                                $real_child->_set_parent($alias, $this);

                                // set modification flag
                                $this->_modified = $modified;
                                $real_child->_modified = $child_modified;
                            }
                        }
                        break;
                    }
                }
                // save fetched state
                $this->_fetched_children[] = $key;
            }
            else if(array_key_exists($key, $this->_many_to_many))
            {
                // get real children
                $child_key = $this->_get_real_pivot_child($key);
                $children = $this->__get($child_key);

                // get the config
                $many_to_many_config = $this->_many_to_many[$key];
                $relation = $many_to_many_config['relation'];

                $virtual_children = array();
                foreach($children as $child)
                {
                    $virtual_child = $child->__get($relation);
                    $virtual_children[] = $virtual_child;
                }
                $this->_values[$key] = $virtual_children;
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

        // set parent as "fetched"
        if(!in_array($relation_name, $this->_fetched_parents))
        {
            $this->_fetched_parents[] = $relation_name;
        }

        // create parent if not exist, or just simply return this val
        $parent = $this->_data_to_entity($val, $class_name);

        // look for parent's children configuration refering to this model
        $backref_relation_name = $this->_get_backref_relation($relation_name);

        if($backref_relation_name != NULL)
        {
            $parent_config = $class_name::_get_static_config();
            $parent_children = $parent->_values[$backref_relation_name];

            // if is exists don't need to do anything. This is also the recursive breaker
            if(!in_array($this, $parent_children))
            {
                $parent->_values[$backref_relation_name][] =& $this;

            }

            // parent should also consider this record as "fetched"
            if(!in_array($backref_relation_name, $parent->_fetched_children))
            {
                $parent->_fetched_children[] = $backref_relation_name;
            }
        }

        // finally after parent's value has been altered as necessary add parent's reference to this model
        $this->_values[$relation_name] =& $parent;
        $this->_values[$foreign_key] = $parent->_get_id();
        $this->_modified = TRUE;
    }


    public function _unset_parent($relation_name)
    {
        // get parent's class name and foreign key from this table to parent
        $relation_config = $this->_parents[$relation_name];
        $class_name = $relation_config['model'];
        $foreign_key = $relation_config['foreign_key'];

        $parent =& $this->_values[$relation_name];
        if($parent != NULL)
        {
            // look for parent's children configuration refering to this model
            $backref_relation_name = $this->_get_backref_relation($relation_name);
            if($backref_relation_name != NULL)
            {
                $parent_config = $parent->_get_config();
                $parent_children = $parent->_values[$backref_relation_name];
                $new_parent_children = array();
                foreach($parent_children as &$parent_child)
                {
                    if($parent_child != $this)
                    {
                        $new_parent_children[] = $parent_child;
                    }
                }
                $parent->_values[$backref_relation_name] =& $new_parent_children;
            }
        }

        // finally after parent's value has been altered as necessary set this parent's reference to NULL 
        $this->_values[$relation_name] = NULL;
        $this->_values[$foreign_key] = NULL;
        $this->_modified = TRUE;
    }

    public function __set($key, $val)
    {
        
        if(method_exists($this, 'set_'.$key))
        {
            call_user_func_array(array($this, 'set_'.$key), array($val));
        }
        else if(in_array($key, $this->_allowed_columns))
        {
            // don't do anything if nothing changed
            if(array_key_exists($key, $this->_values) && $this->_values[$key] == $val)
            {
                return FALSE;
            }
            
            // set modified flag to true
            $this->_modified = TRUE;

            $current_pk = $this->_get_id();
            $current_class_name = get_called_class();

            // children & many to many
            if(array_key_exists($key, $this->_children) || array_key_exists($key, $this->_many_to_many))
            {
                if(!isset($this->_values[$key]))
                {
                    // assigned a new column, then this must be empty first 
                    $this->_values[$key] = array();
                }

                // remove link from old children if the old children is no longer part of new children
                foreach($this->_values[$key] as &$old_child)
                {
                    if($old_child != NULL)
                    {
                        $this->__call('remove_'.$key, array($old_child));
                    }
                }
                // add new children
                foreach($val as &$child_data)
                {
                    $this->__call('add_'.$key, array($child_data));
                }

                // set _fetched children if it is not there
                if(!in_array($key, $this->_fetched_children))
                {
                    $this->_fetched_children[] = $key;
                }
            }

            // parents 
            else if(array_key_exists($key, $this->_parents))
            {
                if($val == NULL)
                {
                    $this->_unset_parent($key);
                }
                else
                {
                    $this->_set_parent($key, $val);
                }
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

    public function _is_deleted()
    {
        return $this->__get($this->_deleted);
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
            'deleted' => $this->_deleted,
            'columns' => $this->_columns,
            'children' => $this->_children,
            'parents' => $this->_parents,
        );
    }

    public function _get_backref_relation($relation_name)
    {
        if(array_key_exists($relation_name, $this->_parents))
        {
            $config = $this->_parents[$relation_name];
            $backref_class = $config['model'];
            $backref_config = $backref_class::_get_static_config();
            $backref_children = $backref_config['children'];
            foreach($backref_children as $backref_relation=>$backref_child_config)
            {
                if(trim($backref_child_config['model'], '\\') == get_called_class() && $backref_child_config['foreign_key'] == $config['foreign_key'])
                {
                    return $backref_relation;
                }
            }
        }
        else if(array_key_exists($relation_name, $this->_children))
        {
            $config = $this->_children[$relation_name];
            $backref_class = $config['model'];
            $backref_config = $backref_class::_get_static_config();
            $backref_parents = $backref_config['parents'];
            foreach($backref_parents as $backref_relation=>$backref_parent_config)
            {
                if(trim($backref_parent_config['model'], '\\') == get_called_class() && $backref_parent_config['foreign_key'] == $config['foreign_key'])
                {
                    return $backref_relation;
                }
            }
        }
        return NULL;
    }

    protected function _sanitize_properties()
    {
        // automatically set _table if not exists
        if(empty($this->_table))
        {
            $class = trim(get_called_class(), '\\');
            $class_parts = explode('\\', $class);
            $table = $class_parts[count($class_parts)-1];

            // try to use class name
            if($this->db->table_exists($table))
            {
                $this->_table = $table;
            }
            else if($this->db->table_exists(strtolower($table)))
            {
                $this->_table = strtolower($table);
            }
        }

        // check the actual field on the database
        if(!$this->db->table_exists($this->_table))
        {
            show_error('Table '.$this->db->dbprefix.$this->_table.' does not exists');
        }

        // get field list
        $field_list = $this->db->list_fields($this->_table);

        if(count($this->_columns) == 0  || !empty($this->_id) || !empty($this->_deleted) || !empty($this->_created_at) || !empty($this->_updated_at) || !empty($this->_deleted_at) || count($this->_parent) > 0)
        {

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
                $new_id_is_set = FALSE;
                foreach ($field_data_list as $field_data)
                {
                    if($field_data->primary_key)
                    {
                        $this->_id = $field_data->name;
                        $new_id_is_set = TRUE;
                        break;
                    }
                }

                if(!$new_id_is_set)
                {
                    show_error('Field '.$this->_id.' was not found in '.$this->db->dbprefix.$this->_table);
                }
            }

            // remove invalid parent
            foreach($this->_parents as $alias => $parent_config)
            {
                if(in_array($alias, $field_list) || !isset($parent_config['foreign_key']) || !isset($parent_config['model']) || !in_array($parent_config['foreign_key'], $field_list))
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
            if(in_array($alias, $field_list) || in_array($alias, $this->_parents) || !isset($children_config['foreign_key']) || !isset($children_config['model']))
            {
                unset($this->_children[$alias]);
                continue;
            }

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

        // remove or repair invalid many_to_many
        foreach($this->_many_to_many as $alias => &$many_to_many_config)
        {
            if(in_array($alias, $field_list) || in_array($alias, $this->_parents) || in_array($alias, $this->_children) || !isset($many_to_many_config['pivot_model']) || !isset($many_to_many_config['backref_relation']))
            {
                unset($this->_many_to_many[$alias]);
                continue;
            }

            // by default pivot relation to lookup table is the same as alias
            if(!isset($many_to_many_config['relation']))
            {
                $many_to_many_config['relation'] = $alias;
            }

            // get pivot class, last check
            $pivot_class = $many_to_many_config['pivot_model'];
            $pivot_config = $pivot_class::_get_static_config();
            $pivot_parent_config = $pivot_config['parents'];
            if(!in_array($many_to_many_config['relation'], array_keys($pivot_parent_config)) || !in_array($many_to_many_config['relation'], array_keys($pivot_parent_config)))
            {
                unset($this->_many_to_many[$alias]);
                continue;
            }

            // fix on_delete
            if(!isset($many_to_many_config['on_delete']) || !in_array($many_to_many_config['on_delete'], array('restrict', 'set_null', 'cascade')))
            {
                $many_to_many_config['on_delete'] = 'restrict';
            }

            // fix on_purge
            if(!isset($many_to_many_config['on_purge']) || !in_array($many_to_many_config['on_purge'], array('restrict', 'set_null', 'cascade')))
            {
                $many_to_many_config['on_purge'] = $many_to_many_config['on_delete'];
            }

            // all clear? now add child
            $this->_children[$this->_get_real_pivot_child($alias)] = array(
                'model' => $many_to_many_config['pivot_model'],
                'foreign_key' => $pivot_parent_config[$many_to_many_config['backref_relation']]['foreign_key'],
                'on_delete' => $many_to_many_config['on_delete'],
                'on_purge' => $many_to_many_config['on_purge']
            );
        }
    }

    public function __construct($obj=array(), $db = NULL)
    {
        parent::__construct();

        // database
        if($db != NULL)
        {
            $this->db = $db;
        }
        else
        {
            $this->load->database();
        }

        $this->_sanitize_properties();
        $this->_set_allowed_columns();

        // assign default values for fields if values set from properties and not started with '_'
        foreach($this->_allowed_columns as $col)
        {
            if(strpos($col, '_')!== 0 && isset($this->$col))
            {
                $this->__set($col, $this->$col);
                unset($this->$col);
            }
        }

        // on creation, children should be empty array if not defined
        foreach(array_keys($this->_children) as $key)
        {
            if(!array_key_exists($key, $this->_values))
            {
                $this->_values[$key] = array();
            }
        }

        // if obj is string and we only have one unique column, let turn it into associative array with unique column as key and obj as val
        if(is_string($obj))
        {
            if(count($this->_unique_columns) == 1)
            {
                $unique_column = $this->_unique_columns[0];
                $obj = array($unique_column => $obj);
            }
            else
            {
                $obj = array();
            }
        }

        // assign properties
        foreach($obj as $key=>$val)
        {
            $this->__set($key, $val);
        }

        // turn off cache if not necessary
        if($this->_turn_off_cache){
            $class = get_called_class(); 
            $class::turn_off_cache();
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

    public function as_string()
    {
        if(count($this->_columns) > 0)
        {
            // get properties of the object
            $properties = get_object_vars($this);
            // forbidden columns are usually defined in underscored properties (such as $_id, $_created_by, etc)
            $forbidden_columns = array();
            foreach($properties as $key=>$val)
            {
                if(strpos($key, '_') === 0 && is_string($val))
                {
                    $forbidden_columns[] = $val;
                }
            }

            // create the array
            helper('inflector');
            $array = array();
            foreach($this->_columns as $col)
            {
                if(in_array($col, $forbidden_columns))
                {
                    continue;
                }
                $array[] = ucwords(humanize($col)) . ' : ' . $this->__get($col);
            }
            return implode(' - ', $array);
        }
        return $this->_get_id();
    }

    public function as_short_string()
    {
        if(count($this->_unique_columns) > 0)
        {
            $array = array();
            foreach($this->_unique_columns as $col)
            {
                $array[] = $this->__get($col);
            }
            return implode(' - ', $array);
        }
        return $this->_get_id();
    }

    protected function _is_old_record()
    {
        $pk = $this->_get_id();
        $is_old_record = $pk != NULL;
        if($is_old_record)
        {
            $class = get_called_class();
            $record = $class::find_by_id($pk, $this->db);
            $is_old_record = $record !== NULL;
        }
        return $is_old_record;
    }

    // save this record
    public function save()
    {
        return $this->_do_save();
    }

    // $success and $error_message are passed for every before and after events
    // $propagate inform whether it is needed to update parent & children as well
    public function _do_save(&$success = TRUE, &$error_message = '', $propagate = TRUE)
    {
        if($this->_evaluated)
        {
            return array('success' => FALSE, 'error_message' => 'Evaluation to this object has been performed');
        }

        // set evaluated flag to true. This way, if parents or children of this object try to propagate do save, it will be rejected
        $this->_evaluated = TRUE;

        $timestamp = date('Y-m-d H:i:s');

        // get table, pk, and data
        $table = $this->_table;
        $pk_field = $this->_id;
        $pk = $this->_get_id();

        // start transaction
        $this->db->trans_start();

        // is this old_record?
        $is_old_record = $this->_is_old_record();

        // protect uniqueness 
        if(count($this->_unique_columns) > 0)
        {
            // assemble where syntax
            $value_information = array();
            $where = array();
            foreach($this->_unique_columns as $col)
            {
                $where[$col] = $this->__get($col);
                $value_information[] = $col . ' : ' . $this->__get($col);
            }
            $value_information = implode(', ', $value_information);

            // get the duplicated records
            $class = get_called_class();
            $duplicate_records = $class::find_where($where); 

            if(count($duplicate_records) > 0)
            {
                if(!$is_old_record)
                {
                    $success = FALSE;
                    $error_message = 'Record with unique attributes (' . $value_information . ') is already exists on table '.$this->db->dbprefix.$this->_table;
                }
                else
                {
                    foreach($duplicate_records as $record)
                    {
                        // if this is old record, compare the primary key, if it is different,
                        // then it is duplication
                        if($this->_get_id() != $record->_get_id())
                        {
                            $success = FALSE;
                            $error_message = 'Record with unique attributes (' . $value_information . ') is already exists on table '.$this->db->dbprefix.$this->_table;
                            break;
                        }
                    }
                }
            }
        }

        // trigger before insert/update
        if($success)
        {
            // before update or before insert
            if($is_old_record)
            {
                $this->before_update($success, $error_message);
            }
            else
            {
                $this->before_insert($success, $error_message);
            }
        }

        // trigger before save
        if($success)
        {
            $this->before_save($success, $error_message);
        }

        // propagate parent
        if($success && $propagate)
        {
            foreach($this->_parents as $alias=>$parent_config)
            {
                if(!in_array($alias, $this->_fetched_parents))
                {
                    continue;
                }

                // skip if parent is NULL
                $parent =& $this->_values[$alias];
                if($parent == NULL || $parent->_is_deleted() || !$parent->_modified){ continue; }

                $parent->_do_save($success, $error_message);
                if(!$success)
                {
                    break;
                }

                // update foreign key and reference to this field
                $fk = $parent_config['foreign_key'];    
                $parent_pk = $parent->_get_id();
                $this->_values[$fk] = $parent_pk;
                $this->_values[$alias] =& $parent;
            }
        }

        // real action (insert/update)
        if($success)
        {
            if($this->_modified && !$this->_is_deleted())
            {
                // anything can happened, this record can already be saved already even if it wasn't initially
                // for example, a record that has itself as parent. 
                $is_old_record = $this->_is_old_record();

                // turn to array
                $simple_array = $this->as_array(TRUE);

                // remove aliases
                foreach(array_keys($this->_parents) as $parent_alias)
                {
                    unset($simple_array[$parent_alias]);
                }
                foreach(array_keys($this->_children) as $child_alias)
                {
                    unset($simple_array[$child_alias]);
                }
                foreach(array_keys($this->_many_to_many) as $many_to_many_alias)
                {
                    unset($simple_array[$many_to_many_alias]);
                }

                // something is going to changed, delete cached_result
                $class = get_called_class();

                // if is_old_record, then update, otherwise insert. Add timestamp as needed
                if($is_old_record)
                {
                    if($this->_updated_at != '')
                    {
                        $simple_array[$this->_updated_at] = $timestamp;
                        $this->_values[$this->_updated_at] = $timestamp;
                    }
                    if($this->_deleted != '')
                    {
                        $simple_array[$this->_deleted] = FALSE;
                        $this->_values[$this->_deleted] = FALSE;
                    }
                    $success = $this->db->update($table, $simple_array, array($pk_field=>$pk));
                    $error = $this->db->error();
                    $error_message = $error['message'];
                }
                else
                {
                    // add timestamp and default _deleted value
                    if($this->_created_at != '')
                    {
                        $simple_array[$this->_created_at] = $timestamp;
                        $this->_values[$this->_created_at] = $timestamp;
                    }
                    if($this->_deleted != '')
                    {
                        $simple_array[$this->_deleted] = FALSE;
                        $this->_values[$this->_deleted] = FALSE;
                    }

                    // insert
                    $success = $this->db->insert($table, $simple_array);
                    $error = $this->db->error();
                    $error_message = $error['message'];

                    if($success)
                    {
                        $pk = $this->db->insert_id();
                        $this->_values[$pk_field] = $pk;
                        $simple_array[$pk_field] = $pk;
                    }
                }

                // override cached record
                if($success)
                {
                    $class::override_cached_record($simple_array);
                }

                // set modified flag to FALSE
                $this->_modified = FALSE;
            }

        }

        // update foreign keys of children
        if($success && $propagate)
        {
            foreach($this->_children as $alias=>$child_config)
            {
                if(!in_array($alias, $this->_fetched_children))
                {
                    continue;
                }

                // get foreign_key in child
                $fk = $child_config['foreign_key'];

                $children = $this->_values[$alias];
                $new_children = array();

                foreach($children as $child)
                {
                    if( $child == NULL || $child->_is_deleted() ){ continue; }

                    if($child->_modified)
                    {
                        // set foreign key and save
                        $child->_values[$fk] = $pk;
                        $child->_do_save($success, $error_message);
                    }

                    $new_children[] = $child;
                    if(!$success)
                    {
                        break;
                    }
                }

                $this->_values[$alias] =& $new_children;
            }
        }

        // trigger after save
        if($success)
        {
            $this->after_save($success, $error_message);

        }

        // trigger after update or after insert
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

        }

        // stop transaction
        if($success)
        {
            $this->db->trans_complete();
        }
        else
        {
            $this->db->trans_rollback();
        }

        $this->_evaluated = FALSE;
        return array('success' => $success, 'error_message' => $error_message);
    }


    // soft delete this record
    public function delete()
    {
        return $this->_do_delete();
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
            return array('success' => FALSE, $error_message = 'Deletion cannot be performed on '.$this->db->dbprefix.$this->_table.'. Primary Key is not defined');
        }

        $timestamp = date('Y-m-d H:i:s');

        // start transaction
        $this->db->trans_start();

        // before delete
        $this->before_delete($success, $error_message);
        if($success)
        {
            // something is going to changed, delete cached_result
            $class = get_called_class();

            // Don't need to change anything else 
            $simple_array = array();

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
            $success = $this->db->update($table, $simple_array, array($pk_field=>$pk));
            $error = $this->db->error();
            $error_message = $error['message'];

            // cut of relationship with parents
            foreach($this->_parents as $alias=>$config)
            {
                $this->_unset_parent($alias);
                $simple_array[$alias] = NULL;
            }

            // override cached record
            if($success)
            {
                $simple_array[$pk_field] = $pk;
                $class::override_cached_record($simple_array);
            }
        }

        // update foreign keys of children
        if($success && $propagate)
        {
            foreach($this->_children as $alias=>$child_config)
            {
                $fk = $child_config['foreign_key'];    
                $on_delete = $child_config['on_delete'];
                $children = $this->__get($alias);

                $backref_alias = $this->_get_backref_relation($alias);

                // set foreign key and delete
                switch($on_delete)
                {
                case 'set_null' :
                    foreach($children as &$child)
                    {
                        $child->_unset_parent($backref_alias);
                        $child->_do_save($success, $error_message, FALSE);
                    }
                    break;

                case 'cascade'  :
                    foreach($children as &$child)
                    {
                        $child->_do_delete($success, $error_message, FALSE);
                        $new_child[] = $child;
                    }
                    break;

                case 'restrict' :
                default :
                    foreach($children as &$child)
                    {
                        $success = FALSE;
                        $error_message = 'Deletion cannot be performed. Table '.$this->db->dbprefix.$this->_table.' still has ' . $alias;
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
        }


        // stop transaction
        if($success)
        {
            $this->db->trans_complete();
        }
        else
        {
            $this->db->trans_rollback();
        }

        return array('success' => $success, 'error_message' => $error_message);
    }

    public function purge()
    {
        return $this->_do_purge();
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
            return array('success' => FALSE, $error_message = 'Purge deletion cannot be performed on '.$this->db->dbprefix.$this->_table.'. Primary Key is not defined');
        }

        $timestamp = date('Y-m-d H:i:s');

        // start transaction
        $this->db->trans_start();

        // before purge
        $this->before_purge($success, $error_message);
        if($success)
        {
            // something is going to changed, delete cached_result
            $class = get_called_class();

            // get data
            $simple_array = $this->as_array(TRUE);

            $success = $this->db->delete($table, array($pk_field=>$pk));
            $error = $this->db->error();
            $error_message = $error['message'];

            // cut of relationship with parents
            foreach($this->_parents as $alias=>$config)
            {
                $this->_unset_parent($alias);
                $simple_array[$alias] = NULL;
            }

            // override cached record
            if($success)
            {
                $simple_array[$pk_field] = $pk;
                $class::override_cached_record($simple_array);
            }
        }

        // update foreign keys of children
        if($success && $propagate)
        {
            foreach($this->_children as $alias=>$child_config)
            {
                $fk = $child_config['foreign_key'];    
                $on_purge = $child_config['on_purge'];
                $children = $this->__get($alias);

                $backref_alias = $this->_get_backref_relation($alias);

                // set foreign key and delete
                switch($on_purge)
                {
                case 'set_null' :
                    foreach($children as &$child)
                    {
                        $child->_unset_parent($backref_alias);
                        $child->_do_save($success, $error_message, FALSE);
                    }
                    break;

                case 'cascade'  :
                    foreach($children as &$child)
                    {
                        $child->_do_purge($success, $error_message, FALSE);
                        $new_child[] = $child;
                    }
                    break;

                case 'restrict' :
                default :
                    foreach($children as &$child)
                    {
                        $success = FALSE;
                        $error_message = 'Purge deletion cannot be performed. Table '.$this->db->dbprefix.$this->_table.' still has ' . $alias;
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
        }


        if($success)
        {
            // stop transaction
            $this->db->trans_complete();
        }
        else
        {
            $this->db->trans_rollback();
        }

        return array('success' => $success, 'error_message' => $error_message);
     }

    ////////////////////////////////////////////////////////////////
    //
    // Static properties and methods 
    //
    ////////////////////////////////////////////////////////////////

    // all static configurations should live here
    protected static $_configs = array();

    // cache SELECT * FROM table
    protected static $_cached_result = array();
    protected static $_is_cachable = array(); // is cached_result allowed (i.e: record in the table less than 1000)
    protected static $_is_cached = array(); // is cached_result has been cached?

    protected static function _activate_cache()
    {
        $class = get_called_class();

        // cached_result
        if(!array_key_exists($class, self::$_cached_result))
        {
            self::$_cached_result[$class] = array();
        }

        // is_cached
        if(!array_key_exists($class, self::$_is_cached))
        {
            self::$_is_cached[$class] = FALSE;
        }

        // is_cachable
        if(!array_key_exists($class, self::$_is_cachable))
        {
            self::$_is_cachable[$class] = NULL;
        }

    }

    public static function reset_cache()
    {
        static::_activate_cache();
        $class = get_called_class(); 
        self::$_cached_result[$class] = array();
        self::$_is_cached[$class] = FALSE;
        if(!array_key_exists($class, self::$_is_cachable) || self::$_is_cachable[$class] !== FALSE)
        {
            self::$_is_cachable[$class] = NULL;
        }
    }

    public static function override_cached_record($new_record)
    {
        static::_activate_cache();
        $class = get_called_class();

        if(array_key_exists($class, self::$_is_cached) && array_key_exists($class, self::$_is_cachable) && self::$_is_cached[$class] && self::$_is_cachable[$class] === TRUE)
        {
            $config = static::_get_static_config();
            $id_key = $config['id'];

            // is record with the same id exists?
            $found = FALSE;
            foreach(self::$_cached_result[$class] as &$record)
            {
                if($record[$id_key] == $new_record[$id_key])
                {
                    // found it, update and done...
                    foreach($new_record as $key=>$val)
                    {
                        $record[$key] = $val;
                    }
                    $found = TRUE;
                    break;
                }
            }

            // Not found, then the new record should be inserted
            if(!$found)
            {
                $columns = $config['columns'];
                foreach($columns as $column)
                {
                    if(!array_key_exists($column, $new_record))
                    {
                        $new_record[$column] = NULL;
                    }
                }
                self::$_cached_result[$class][] = $new_record;
            }
        }
    }

    public static function purge_cached_record($old_id)
    {
        static::_activate_cache();
        $class = get_called_class();

        if(array_key_exists($class, self::$_is_cached) && array_key_exists($class, self::$_is_cachable) && self::$_is_cached[$class] && self::$_is_cachable[$class] === TRUE)
        {
            $config = static::_get_static_config();
            $id_key = $config['id'];
            for($i=0; $i<count(self::$_cached_result[$class]); $i++)
            {
                $record = self::$_cached_result[$class][$i];
                if($record[$id_key] == $old_id)
                {
                    array_splice(self::$_cached_result[$class], $i, 1);
                    break;
                }
            }
        }
    }

    public static function turn_on_cache()
    {
        static::_activate_cache();
        $class = get_called_class();

        self::$_is_cachable[$class] = NULL;
    }

    public static function turn_off_cache()
    {
        static::_activate_cache();
        $class = get_called_class();

        static::reset_cache();
        self::$_is_cachable[$class] = FALSE;
    }

    public static function get_cached_result(&$db = NULL)
    {
        static::_activate_cache();
        $class = get_called_class();

        // if cache is not allowed
        if(self::$_is_cachable[$class] === FALSE)
        {
            return NULL;
        }

        // cache already exists? return it
        if(self::$_is_cached[$class])
        {
            return self::$_cached_result[$class];
        }

        if($db == NULL)
        {
            $CI =& get_instance();
            $db =& $CI->db;
        }
        $config = static::_get_static_config();
        $table = $config['table'];

        // is this cachable (assuming count of max cachable table is 1000)
        if(self::$_is_cachable[$class] === NULL)
        {
            self::$_is_cachable[$class] = $db->count_all($table) <= 1000;
        }

        if(self::$_is_cachable[$class])
        {
            // cache it
            self::$_cached_result[$class] = $db->get($table)->result_array();
            self::$_is_cached[$class] = TRUE;
            // return the cache
            return self::$_cached_result[$class];
        }
        return NULL;
    }

    public static function _get_static_config()
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
            $instance = new $class(array());
            $config = $instance->_get_config();
            unset($instance);

            $config['class'] = $class;
            self::$_configs[$class] = $config;
        }

        // return the configuration
        return self::$_configs[$class];
    }

    public static function find_all($limit=1000, $offset=0, &$db = NULL)
    {
        // init db and get config
        $config = static::_get_static_config();
        $class = $config['class'];
        $table = $config['table'];
        $id_field = $config['id'];

        if($config['deleted'])
        {
            return static::find_where($config['deleted'], FALSE, NULL, $limit, $offset, $db);
        }

        if($db == NULL)
        {
            $CI =& get_instance();
            $db =& $CI->db;
        }

        // using default parameters? then try to use cache
        if($limit == 1000 && $offset == 0)
        {
            $cached_result = static::get_cached_result($db);
            if($cached_result != NULL)
            {
                return static::result_to_object($cached_result, $db);
            }
        }

        // prepare query
        $query = $db->select('*')
            ->from($table)
            ->limit($limit, $offset);

        $result = static::find_by_query($query);
        return $result;
    }

    public static function find_by_id($id, &$db = NULL)
    {
        // init db and get config
        $config = static::_get_static_config();
        $id_field = $config['id'];

        $result = static::find_where($id_field, $id, NULL, 1000, 0, $db);
        if(count($result) > 0)
        {
            $row = $result[0];
            return $row;
        }
        return NULL;
    }


    public static function find_where($key, $value = NULL, $escape = NULL, $limit=1000, $offset=0, &$db = NULL)
    {
        // init db and get config
        $config = static::_get_static_config();
        $class = $config['class'];
        if($db == NULL)
        {
            $CI =& get_instance();
            $db =& $CI->db;
        }
        $table = $config['table'];
        $id_field = $config['id'];
        $deleted_field = $config['deleted'];

        // using default parameters? then try to use cache
        if($escape === NULL && $limit == 1000 && $offset == 0)
        {
            // normalize where
            $where = array();
            if(is_array($key))
            {
                $where = $key;
            }
            else
            {
                $where = array($key => $value);
            }

            // is where only contains simple key=>value, or is the key contains comparison?
            $complex_key = FALSE;
            foreach($where as $where_key=>$where_value)
            {
                if(strpos($where_key, '>') !== FALSE  || strpos($where_key, '<') !== FALSE  || strpos($where_key, '!') !== FALSE || strpos($where_key, '=') !== FALSE)
                {
                    $complex_key = TRUE;
                    break;
                }
            }

            // if the key contains comparison, it is not going to be easy, just do it the normal way, without cache
            if(!$complex_key)
            {
                $cached_result = static::get_cached_result($db);
                if($cached_result !== NULL)
                {
                    $return = array();
                    foreach($cached_result as $result)
                    {
                        $passed = TRUE;
                        foreach($where as $where_key=>$where_value)
                        {
                            if($result[$where_key] != $where_value)
                            {
                                $passed = FALSE;
                                continue;
                            }
                        }
                        if(!$passed){ continue; }

                        $object_array = static::result_to_object(array($result), $db);
                        $return[] = $object_array[0];
                    }
                    return $return;
                }
            }
        }

        // prepare query
        $query = $db->select('*')
            ->from($table)
            ->where($key, $value, $escape)
            ->limit($limit, $offset);

        $result = static::find_by_query($query);
        return $result;
    }

    public static function find_by_query($query)
    {
        $CI =& get_instance();
        $db =& $CI->db;

        // execute query
        if(is_string($query))
        {
            $query = $db->query($query);
        }
        else if(method_exists($query, 'get'))
        {
            $query = $query->get();
        }

        $sql = $db->last_query(); 

        // run query and parse the result
        return static::result_to_object($query->result_array(), $db);
    }

    protected static function &result_to_object($array_of_result, &$db)
    {
        // get class name 
        $config = static::_get_static_config();
        $class = $config['class'];

        // prepare return value
        $return = array();
        foreach($array_of_result as $row)
        {
            $obj= new $class($row, $db);
            $obj->_modified = FALSE;
            $return[] = $obj;
        }
        return $return;
    }

}
