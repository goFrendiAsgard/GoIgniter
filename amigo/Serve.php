<?php
class Serve{
    function run($arguments = array()){
        $server = get_array_value($arguments, 0, 'localhost');
        $port = get_array_value($arguments, 1, '8080');
        $php = PHP_BINARY;
        outln('GoIgniter run at '.$server.':'.$port.', press Ctrl+c to stop');
        passthru($php .' -S '.$server.':'.$port);
    }
}
