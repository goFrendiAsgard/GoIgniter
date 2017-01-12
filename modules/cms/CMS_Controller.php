<?php
namespace Modules\Cms;

abstract class CMS_Controller extends \CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __call($method, $parameters)
    {
        if(method_exists($this, $method))
        {
            // get comment
            $ref = new \ReflectionMethod($this, $method);
            $comment = $ref->getDocComment();

            // init code
            $code = '';

            // get comment parts
            if($code !== FALSE)
            {
                $comment_parts = explode(PHP_EOL, $comment);
                foreach($comment_parts as $line)
                {
                    $line = trim(ltrim($line, '/* '));
                    if(substr($line, 0, 5) == '@code')
                    {
                        $code = trim(substr($line,5), '()"\'');
                        break;
                    }
                }
            }

            // okay, here we got the code
            var_dump($code);

            return call_user_func_array(array($this, $method), $parameters);
        }
    }

}
