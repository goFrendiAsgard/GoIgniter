<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Go_Model extends CI_Model
{
    protected $_site_table = 'site';
    protected $_site_column_id = 'id';
    protected $_site_column_code = 'code';
    protected $_site_column_names = 'alias';
    protected $_site_name_delimiter = ',';
    protected $_hostname = 'localhost';

    protected static $site_id;

    public function __construct()
    {
        parent::__construct();
    }
}
