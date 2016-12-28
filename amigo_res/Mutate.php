<?php
require_once('res/Mutation_maker.php');

class Mutate extends Mutation_maker{

    public $description = "Mutate GoIgniter into No-CMS 2.0";

    public $parameter = "[module_path [app_path]]";

    public function run($arguments = array())
    {
        // get mutator
        $mutator = parent::get_mutator($arguments);
        $result = $mutator->do_mutation();

        if($result)
        {
            outln('Mutation done');
        }
        else
        {
            outln('Mutation cannot be performed : ' . $mutator->get_error_message());
        }
    }

}
