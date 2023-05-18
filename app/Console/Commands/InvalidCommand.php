<?php declare(strict_types=1);

namespace App\Console\Commands;

class InvalidCommand
{
    public static function execute():void
    {
        echo "Invalid arguments.\n";
    }
}
