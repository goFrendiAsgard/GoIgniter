<?php
namespace Modules\Cms;

use \Unit_test;

class Test_Controller extends \CI_Controller
{

    private $_tests = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('inflector');
        $this->unit = new \Unit_test();

        foreach(get_class_methods($this) as $method)
        {
            if(substr($method,0,4) == 'test')
            {
                $this->_tests[] = $method;
            }
        }
    }

    public function global_setup()
    {
        // run once before all the test
    }

    public function global_tearDown()
    {
        // run once after all the test
    }

    public function setup()
    {
        // run before each test
    }

    public function tearDown()
    {
        // run after each test
    }

    public function index()
    {
        $this->global_setup();
        $separator = array();
        foreach($this->_tests as $test)
        {
            $this->setup();

            // get result count
            $result = $this->unit->result();
            $result_count = count($result);
            $separator[$result_count] = humanize($test);

            if(method_exists($this, $test))
            {
                $this->{$test}();
            }

            $this->tearDown();
        }
        $this->global_tearDown();

        // create the result
        $result = $this->unit->result();
        $result_count = count($result);
        $passed_count = 0;
        $failed_count = 0;
        foreach($result as $row)
        {
            if($row['Result'] == 'Passed')
            {
                $passed_count ++;
            }
            else
            {
                $failed_count ++;
            }
        }
        $data = array(
            'separator' => $separator,
            'result' => $result,
            'total' => $result_count,
            'passed' => $passed_count,
            'failed' => $failed_count,
        );
        view('cms/test_controller_index', $data);
    }

}
