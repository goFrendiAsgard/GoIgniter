<?php defined('BASEPATH') OR exit('No direct script access allowed');

// In simple cases, we don't need to extend this

class Go_Entity
{
    public $_as; // this will be assigned by Model, please don't override this

    public function __construct($array = array())
    {
        foreach($array as $key=>$val)
        {
            $this->$key = $val;
        }
    }

    public function __call($method, $args)
    {
        if (isset($this->$method)) {
            $func = $this->$method;
            return call_user_func_array($func, $args);
        }
    }

}
