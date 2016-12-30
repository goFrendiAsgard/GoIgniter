<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Go_Model extends CI_Model
{
    protected $_table = '';
    protected $_id = 'id';
    protected $_created_at = '_created_at';
    protected $_deleted_at = '_deleted_at';
    protected $_updated_at = '_updated_at';
    protected $_deleted    = '_deleted';
    protected $_columns    = array();
    protected $_return     = 'array'; // or entity class name

    public function __construct($db = NULL)
    {
        if($db !== NULL)
        {
            $this->db = $db;
        }
        else
        {
            $this->load->database();
        }
    }

    protected function preprocess_result($result)
    {
        if($this->_return === 'array')
        {
            return $result;
        }
        else
        {
            $new_result = array();
            foreach($result as $obj)
            {
                $new_result[] = new $this->_return($obj);
            }
            return $new_result;
        }
    }

    protected function before_save($data)
    {
        return $data;
    }

    protected function after_save($data)
    {
        return $data;
    }

    protected function before_insert($data)
    {
        return $data;
    }

    protected function after_insert($data)
    {
        return $data;
    }

    protected function before_update($data)
    {
        return $data;
    }

    protected function after_update($data)
    {
        return $data;
    }
    
    protected function before_delete($data)
    {
        return $data;
    }

    protected function after_delete($data)
    {
        return $data;
    }

    protected function before_delete_purge($data)
    {
        return $data;
    }

    protected function after_delete_purge($data)
    {
        return $data;
    }

    public function save($data)
    {
        $data = $this->before_save($data);
        $data = $this->after_save($data);
    }

    public function insert($data)
    {
        $data = $this->before_insert($data);
        $data = $this->after_insert($data);
    }

    public function update($data, $where)
    {
        $data = $this->before_update($data);
        $data = $this->after_update($data);
    }

    public function delete($where)
    {
        $data = $this->before_delete($data);
        $data = $this->after_delete($data);
    }

    public function delete_purge($where)
    {
        $data = $this->before_delete_purge($data);
        $data = $this->after_delete_purge($data);
    }

    public function delete_by_id($id)
    {
        $this->delete(array($this->_id=>$id));
    }

    public function delete_purge_by_id($id)
    {
        $this->delete_purge(array($this->_id=>$id));
    }

    public function find($id)
    {
        return $this->find_where('id', $this->_id);
    }

    public function find_where($key, $value=NULL, $escape=TRUE)
    {
        $query = $this->db->select('*')
            ->from($this->_table)
            ->where($key, $value, $escape)
            ->get();
        return $this->find_by_query($query);
    }

    public function find_by_query($query)
    {
        return $this->preprocess_result($query->result());
    }


    public function find_all($query)
    {
        return $this->preprocess_result($query->result());
    }

    public function encode_id($id)
    {
        return base64_encode($id);
    }

    public function decode_id($id)
    {
        return base64_decode($id);
    }

}
