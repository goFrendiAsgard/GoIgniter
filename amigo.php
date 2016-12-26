#!/usr/local/bin/php
<?php

function out($message)
{
    fwrite(STDOUT, $message);
}

function in($message = NULL)
{
    if($message !== NULL)
    {
        out($message);
    }
    return fgets(STDIN);
}

function outln($message)
{
    out($message . PHP_EOL);
}

function get_array_value($array, $index, $default_value = NULL)
{
    if(array_key_exists($index, $array))
    {
        return $array[$index];
    }
    else
    {
        return $default_value;
    }
}

function show_help()
{
    $amigo = $argv[0];
    $message = 
        "USAGE :" . PHP_EOL .
        "* Help" . PHP_EOL .
        "   php $amigo help" . PHP_EOL .
        "* Run server" . PHP_EOL .
        "   php $amigo serve [server [port]]";

    outln($message);
}

if($argc == 1 || ($argc == 2 && $argv[1] == "help"))
{
    show_help();
}
else if($argc == 2 && $argv[1] == "?")
{
    outln(" Do you just ask `Am I Go?`");
    outln(" No, you are not, I don't know who you are. And I'm not `Go` too. I am Amigo, a simple PHP CLI program.");
    outln(" `Go` is the programmer who made me.");
    outln(" You can stalk his github on https://github.com/goFrendiAsgard");
    show_help();
}
else if($argc > 1)
{
    $command = $argv[1];
    $arguments = array_slice($argv, 2);
    // run the class
    $class = ucfirst($command);
    require_once(__DIR__ .'/amigo/'.$class.'.php');
    $obj =  new $class();
    $obj->run($arguments);
}
else
{
    outln("This should never be shown, but in case it is, please run away, zombie apocalypse will come very soon");
}

