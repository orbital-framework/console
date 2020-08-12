<?php

namespace Orbital\Console;

use \Exception;
use \Orbital\Framework\App;

abstract class Command {

    /**
     * Commands
     * @var array
     */
    public static $commands = array();

    /**
     * Add command watcher
     * OBS. Command can accept more than one callback
     * @param string $command
     * @param string $callback
     * @param mixed $times
     * @return void
     */
    public static function on($command, $callback, $times = 1){

        if( !isset(self::$commands[ $command ]) ){
            self::$commands[ $command ] = array();
        }

        self::$commands[ $command ][] = array(
            'callback' => $callback,
            'times' => $times
        );

    }

    /**
     * Print registered commands
     * @return void
     */
    public static function printCommands(){

        $commands = self::$commands;
        ksort($commands);

        foreach( $commands as $command => $tasks ){
            foreach( $tasks as $task ){

                $line = "$command";
                $line .= " -> ";
                $line .= $task['callback'];

                if( $task['times'] > 1 ){
                    $line .= " (runs ". $task['times']. " times)";
                }

                Console::print($line);

            }
        }

    }

    /**
     * Run command method
     * @param string $command
     * @return void
     */
    public static function run($command = ''){

        if( $command === 'help' ){
            self::printCommands();
            exit;
        }

        if( !$command ){
            Console::eprint("Command not found");
            exit;
        }

        if( !isset(self::$commands[ $command ]) ){
            Console::eprint("Command not exists: ". $command);
            exit;
        }

        $tasks = self::$commands[ $command ];

        foreach( $tasks as $task ){

            try{

                for( $i = 0; $i < $task['times']; $i++ ){
                    App::runMethod($task['callback']);
                }

            }catch( Exception $e ){
                Console::eprint( $e->getMessage() );
            }

        }

        exit;
    }

}