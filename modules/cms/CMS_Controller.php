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
            $ref = new \ReflectionMethod($this, $method);
            $comment = $ref->getDocComment();

            //var_dump($comment);
            // TODO: Parse the comment, implement Middleware, change the world, stay cool !!!

            return call_user_func_array(array($this, $method), $parameters);
        }
    }

}
