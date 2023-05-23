<?php declare(strict_types=1);

namespace App\Console;

class Router
{
    public static function run(string $command, ?int $id): void
    {
        $commands = [
            'articles' => \App\Console\Commands\ArticlesCommand::class,
            'article' => \App\Console\Commands\ArticleCommand::class,
            'user' => \App\Console\Commands\UserCommand::class,
        ];

        if (array_key_exists($command, $commands)) {
            $commandClass = $commands[$command];
            $commandInstance = new $commandClass();

            if ($id !== null || $command === 'articles') {
                $commandInstance->execute($id);
            } else {
                \App\Console\Commands\InvalidCommand::execute();
            }
        } else {
            \App\Console\Commands\InvalidCommand::execute();
        }
    }
}
