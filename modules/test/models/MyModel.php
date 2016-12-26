<?php
namespace Modules\Test\Models;

class MyModel extends \CI_Model{

    function get_data(){
        return array(
            array('title' => 'Sun', 'content' => 'Closest sun'),
            array('title' => 'Moon', 'content' => 'Rock'),
        );
    }

}
