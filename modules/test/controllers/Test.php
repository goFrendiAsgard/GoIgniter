<?php
namespace Modules\Test\Controllers;

class Test extends \CI_Controller
{
    public function index()
    {
        echo 'run <i>test</i> or <i>test/index</i>';
    }

    public function ok()
    {
        echo 'run <i>test/ok</i>';
    }
}
