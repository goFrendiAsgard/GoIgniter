<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Config extends CI_Config{

	public $_config_paths =	array(APPPATH, EXTCONFIGPATH);

    public function __construct()
	{

        // Modified by GoFrendi, enforce replacement from application/core/config/config.php if exists
        $config = array();
        $config_file = EXTCONFIGPATH.'config/config.php';
        if(file_exists($config_file) && is_readable($config_file))
        {
            include $config_file;
        }
		$this->config =& get_config($config);

		// Set the base_url automatically if none was provided
		if (empty($this->config['base_url']))
		{
            // Added by GoFrendi, use SERVER_NAME first if possible, before trying SERVER_ADDR
            if (isset($_SERVER['SERVER_NAME']))
            {
                $server_addr = $_SERVER['SERVER_NAME'];
                $base_url = (is_https() ? 'https' : 'http').'://'.$server_addr
                    .(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80'? ':'.$_SERVER['SERVER_PORT'] : '')
					.substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
            }
            else if (isset($_SERVER['SERVER_ADDR']))
			{
				if (strpos($_SERVER['SERVER_ADDR'], ':') !== FALSE)
				{
					$server_addr = '['.$_SERVER['SERVER_ADDR'].']';
				}
				else
				{
					$server_addr = $_SERVER['SERVER_ADDR'];
				}

				$base_url = (is_https() ? 'https' : 'http').'://'.$server_addr
					.substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
			}
			else
			{
				$base_url = 'http://localhost/';
			}

			$this->set_item('base_url', $base_url);
		}

		// Set the asset_url automatically if none was provided
        if(empty($this->config['asset_url']))
        {
            $base_url = $this->config['base_url'];

            // change them into array
            $base_url_parts = explode('/', $base_url);
            $asset_parts = explode(DIRECTORY_SEPARATOR, ASSETPATH);
            $base_parts = explode(DIRECTORY_SEPARATOR, FCPATH);

            // see, where the asset_parts and base_parts starting to split
            $different_index = 0;
            while(array_slice($asset_parts, 0, $different_index + 1) == array_slice($base_parts, 0, $different_index + 1))
            {
                $different_index++;
            }

            // the base ground between base_url and asset_url
            $asset_url_parts = array();
            if(count($base_parts) == $different_index+1)
            {
                $asset_url_parts = $base_url_parts;
            }
            else
            {
                $trimmed_count = count($base_parts) - $different_index;
                $used_count = count($base_url_parts) - $trimmed_count;
                $asset_url_parts = array_slice($base_url_parts, 0, $used_count);
            }

            // asset_url_parts is only contains http
            if(count($asset_url_parts) < 3)
            {
                $this->set_item('asset_url', 'http://localhost/');
            }
            else
            {
                // remove extra empty last element if exists (which will be translated as extra trailing slash)
                if($asset_url_parts[count($asset_url_parts)-1] == '')
                {
                    array_pop($asset_url_parts);
                }

                // assemble the missing part of asset url based on asset path.
                foreach(array_slice($asset_parts, $different_index) as $part)
                {
                    $asset_url_parts[] = $part;
                }
                $asset_url = implode('/', $asset_url_parts);

                $this->set_item('asset_url', $asset_url);
            }

        }

		log_message('info', 'Config Class Initialized');
	}

    public function asset_url($uri = '', $protocol = NULL)
	{
		$asset_url = $this->slash_item('asset_url');

		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$asset_url = substr($asset_url, strpos($asset_url, '//'));
			}
			else
			{
				$asset_url = $protocol.substr($asset_url, strpos($asset_url, '://'));
			}
		}

		return $asset_url.$this->_uri_string($uri);
	}

}

