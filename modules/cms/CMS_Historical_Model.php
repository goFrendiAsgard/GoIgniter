<?php
namespace Modules\Cms;
use \Modules\Cms\CMS_Model;

abstract class CMS_Historical_Model extends CMS_Model
{
    protected $_history_table = '';
    protected $_history_foreign_key = '';
    protected $_history_changed_on = 'changed_on';
    protected $_history_columns = array();

    public function __construct($obj = array(), $db = NULL)
    {
        parent::__construct($obj, $db);
        if($this->_history_table == '')
        {
            $this->_history_table = $this->_table.'_history';
        }
    }

    protected function after_save(&$success, &$error_message)
    {
        parent::after_save($success, $error_message);

        // get the real record, since we need the complete column's value
        $real_record = static::find_by_id($this->_get_id());
        $data = array();
        foreach($this->_history_columns as $col)
        {
            $data[$col] = $real_record->__get($col);
        }
        $data[$this->_history_foreign_key] = $real_record->_get_id();
        $data[$this->_history_changed_on] = date('Y-m-d H:i:s');

        // insert history
        $this->db->insert($this->_history_table, $data);
    }

    public function restore($datetime_string = NULL)
    {
        $history_row = NULL;
        if($datetime_string == NULL)
        {
            // if datetime_string is NULL, actual datetime_string is the first record of the history
            $history_row = $this->db->select($this->_history_changed_on)
                ->from($this->_history_table)
                ->where(array(
                    $this->_history_foreign_key => $this->_get_id()
                ))
                ->order_by($this->_history_changed_on)
                ->get()->row_array();
        }
        else
        {
            // if datetime_string is NOT NULL, actual datetime_string is the maximum datetime_string of the history which is less than datetime_string
            $history_row = $this->db->select_max($this->_history_changed_on)
                ->from($this->_history_table)
                ->where(array(
                    $this->_history_foreign_key => $this->_get_id(),
                    $this->_history_changed_on . ' <= ' => $datetime_string,
                ))
                ->get()->row_array();
        }

        // get real datetime_string
        if($history_row != NULL)
        {
            $datetime_string = $history_row[$this->_history_changed_on];
        }

        // get row
        $row = $this->db->select('*')
            ->from($this->_history_table)
            ->where(array(
                $this->_history_foreign_key => $this->_get_id(),
                $this->_history_changed_on => $datetime_string,
            ))
            ->get()->row_array();
        if($row != NULL)
        {
            foreach($this->_history_columns as $column)
            {
                $this->__set($column, $row[$column]);
            }
            $this->save();
        }
    }

}
