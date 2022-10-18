<?php
declare(strict_types=1);

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
     * @param int $times
     * @return void
     */
    public static function on(string $command, string $callback, int $times = 1): void {

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
    public static function printCommands(): void {

        $commands = self::$commands;
        ksort($commands);

        foreach( $commands as $command => $tasks ){
            foreach( $tasks as $task ){

                $line = $command;
                $line .= ' -> ';
                $line .= $task['callback'];

                if( $task['times'] > 1 ){
                    $line .= ' (self runs '. $task['times']. ' times)';
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
    public static function run(string $command = ''): void {

        if( $command === 'help' ){
            self::printCommands();
            exit;
        }

        if( !$command ){
            Console::ePrint('Command is required. Use the command "help" to see the available commands.');
            exit;
        }

        if( !isset(self::$commands[ $command ]) ){
            Console::ePrint('Command not exists: '. $command. '.');
            exit;
        }

        $tasks = self::$commands[ $command ];

        foreach( $tasks as $task ){

            try{

                for( $i = 0; $i < $task['times']; $i++ ){
                    App::runMethod($task['callback']);
                }

            }catch( Exception $e ){
                Console::ePrint( $e->getMessage() );
            }

        }

        exit;
    }

}