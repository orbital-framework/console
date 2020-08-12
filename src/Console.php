<?php

namespace Orbital\Console;

abstract class Console {

    /**
     * Print message to STDOUT
     * @param string $message
     * @return void
     */
    public static function print($message){
        echo $message. PHP_EOL;
    }

    /**
     * Print message to STDERR
     * @param string $message
     * @return void
     */
    public static function eprint($message){
        fwrite(STDERR, $message. PHP_EOL);
    }

}