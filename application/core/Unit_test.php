<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(BASEPATH.'libraries/Unit_test.php');

class Unit_test extends CI_Unit_test
{
    protected $_test_items_visible	= array(
		'test_name',
		'test_datatype',
		'res_datatype',
		'result',
		'file',
		'line',
        'notes',
        'test',
        'expected',
	);

    private function pretty_val($val)
    {
        ob_start();
        var_export($val);
        $val_var_dump = ob_get_contents();
        @ob_end_clean();
        return $val_var_dump;
    }

    public function assertEquals($expected, $test, $test_name = 'undefined', $notes = '')
    {
        if($notes === '' && $test !== $expected)
        {
            $notes = 'Test : ' . $this->pretty_val($test) . PHP_EOL .
                'Expected : ' . $this->pretty_val($expected);
        }
        return run($test, $expected, $test_name, $notes);
    }

    public function assertArrayHasKey($array, $key, $test_name = 'undefined', $notes = '')
    {
        $test = array_key_exists($key, $array);
        $expected = TRUE;

        if($notes === '' && $test !== TRUE)
        {
            $notes = 'Expected Array Key : ' . $this->pretty_val($key) . PHP_EOL .
                'Actual Array Key : ' . $this->pretty_val(array_keys($array));
        }

        return run($test, $expected, $test_name, $notes);
    }

    public function run($test, $expected = TRUE, $test_name = 'undefined', $notes = '')
	{
		if ($this->active === FALSE)
		{
			return FALSE;
		}

		if (in_array($expected, array('is_object', 'is_string', 'is_bool', 'is_true', 'is_false', 'is_int', 'is_numeric', 'is_float', 'is_double', 'is_array', 'is_null', 'is_resource'), TRUE))
		{
			$result = $expected($test);
			$extype = str_replace(array('true', 'false'), 'bool', str_replace('is_', '', $expected));
		}
		else
		{
			$result = ($this->strict === TRUE) ? ($test === $expected) : ($test == $expected);
			$extype = gettype($expected);
		}

		$back = $this->_backtrace();

		$report = array (
			'test_name'     => $test_name,
			'test_datatype' => gettype($test),
			'res_datatype'  => $extype,
			'result'        => ($result === TRUE) ? 'passed' : 'failed',
			'file'          => $back['file'],
			'line'          => $back['line'],
            'notes'         => $notes,
            'test'          => $this->pretty_val($test),
            'expected'      => $this->pretty_val($expected),
		);

		$this->results[] = $report;

		return $this->report($this->result(array($report)));
	}

    public function result($results = array())
	{
		$CI =& get_instance();
		$CI->load->language('unit_test');

		if (count($results) === 0)
		{
			$results = $this->results;
		}

		$retval = array();
		foreach ($results as $result)
		{
			$temp = array();
			foreach ($result as $key => $val)
			{
				if ( ! in_array($key, $this->_test_items_visible))
				{
					continue;
				}
				elseif (in_array($key, array('test_name', 'test_datatype', 'res_datatype', 'result'), TRUE))
				{
					if (FALSE !== ($line = $CI->lang->line(strtolower('ut_'.$val), FALSE)))
					{
						$val = $line;
					}
				}

                // Added by Go Frendi
                if($CI->lang->line('ut_'.$key, FALSE))
                {
				    $temp[$CI->lang->line('ut_'.$key, FALSE)] = $val;
                }
                else
                {
                    $CI->load->helper('inflector');
                    $temp[humanize($key)] = $val;
                }
			}
			$retval[] = $temp;
		}

		return $retval;
	}

}
