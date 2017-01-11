<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Go_Migration extends CI_Migration
{
    public function add_default_fields()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'deleted' => array(
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'deleted_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
    }

    public function __call($method, $arguments)
    {
        if(method_exists($this->dbforge, $method))
        {
            return call_user_func_array(array($this->dbforge, $method), $arguments);
        }
        else
        {
            parent::__call($method, $arguments);
        }
    }

    public function __get($var)
    {
        if(strpos(strtoupper($var), 'TYPE_') === 0)
        {
            // preprocess $var
            $var = substr($var, 5);
            $var = strtoupper($var);
            $var = str_replace("NOT_NULL", "NOTNULL", $var);

            if($var == 'FOREIGN_KEY' || $var == 'FOREIGNKEY')
            {
                return array(
                    'type' => 'BIGINT',
                    'constraint' => 20,
                    'unsigned' => TRUE,
                    'null' => TRUE,
                );
            }
            else if($var == 'PRIMARY_KEY' || $var == 'PRIMARYKEY' || $var == 'KEY')
            {
                return array(
                    'type' => 'BIGINT',
                    'constraint' => 20,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                );
            }


            $result = array(
                "null" => FALSE,
                "type" => "VARCHAR",
            );

            // determine NULL
            if(strpos($var, 'NOTNULL') !== FALSE)
            {
                $var = str_replace("NOTNULL", "", $var);
            }else if(strpos($var, 'NULL') !== FALSE)
            {
                $result["null"] = TRUE;
                $var = str_replace("NULL", "", $var);
            }

            // determine UNSIGNED
            if(strpos($var, 'UNSIGNED') !== FALSE)
            {
                $result["unsigned"] = TRUE;
                $var = str_replace("UNSIGNED", "", $var);
            }

            // determine type
            $type_list = array('MEDIUMTEXT', 'MEDIUMBLOB', 'TIMESTAMP', 'MEDIUMINT', 'LONGTEXT', 'LONGBLOB',
                'SMALLINT', 'DATETIME', 'TINYTEXT', 'TINYINT', 'DECIMAL', 'VARCHAR', 'BIGINT', 'DOUBLE',
                'FLOAT', 'TEXT', 'BLOB', 'DATE', 'TIME', 'YEAR', 'CHAR', 'INT',
            );
            foreach($type_list as $type)
            {
                if(strpos($var, $type) !== FALSE)
                {
                    $result["type"] = $type;
                    $var = str_replace($type, "", $var);
                    break;
                }
            }

            if($result["type"] == "VARCHAR")
            {
                $result["constraint"] = 50;
            }

            // determine constraint
            $var = trim($var, '_');
            if($var != 0)
            {
                $var = intval($var);
                $result["constraint"] = $var;
            }

            return $result;
        }
        return parent::__get($var);
    }

}
