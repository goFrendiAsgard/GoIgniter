<?php
namespace Modules\Cms\Controllers;

use \Modules\Cms\CMS_Controller;
use \Modules\Cms\Models\Genesis;

class Cms extends CMS_Controller 
{

    /**
     * This is a comment
     */
    protected function index()
    {
        view('cms/cms_index');
    }

}
