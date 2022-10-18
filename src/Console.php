<?php
declare(strict_types=1);

namespace Orbital\Console;

abstract class Console {

    /**
     * Print message to STDOUT
     * @param string $message
     * @return void
     */
    public static function print(string $message): void {
        echo $message. PHP_EOL;
    }

    /**
     * Print message to STDERR
     * @param string $message
     * @return void
     */
    public static function ePrint(string $message): void {
        fwrite(STDERR, $message. PHP_EOL);
    }

}