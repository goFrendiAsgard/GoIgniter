<?php
require_once('res/Mutation_maker.php');

class Cure extends Mutation_maker{

    public $description = "Undo the Mutation";

    public $parameter = "[module_path [app_path]]";

    public function run($arguments = array())
    {
        // get mutator
        $mutator = parent::get_mutator($arguments);
        $result = $mutator->undo_mutation();

        if($result)
        {
            outln('Mutation undone');
        }
        else
        {
            outln('Mutation cannot be undone : ' . $mutator->get_error_message());
        }
    }

}
