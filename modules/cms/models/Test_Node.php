<?php
namespace Modules\Cms\Models;

class Test_Node extends \Go_Model
{
    protected $_table = 'test_node';
    protected $_id = 'id';
    protected $_created_at = 'created_at';
    protected $_updated_at = 'updated_at';
    protected $_deleted_at = 'deleted_at';
    protected $_deleted = 'deleted';
    protected $_columns = ['code', 'parent_id', 'child_count'];

    protected $code = 'default';

    protected $_children = array(
        'children' => array(
            'model' => 'Modules\Cms\Models\Test_Node',
            'foreign_key' => 'parent_id',
            'on_delete' => 'set_null', // restrict, cascade, set_null
            'on_purge' => 'set_null', // restric, cascade, set_null
        ),
    );

    protected $_parents = array(
        'parent' => array(
            'model' => 'Modules\Cms\Models\Test_Node',
            'foreign_key' => 'parent_id',
        ),
    );

    protected function before_save(&$success, &$error_message)
    {
        $this->child_count = count($this->children);
    }
}
