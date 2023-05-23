<?php declare(strict_types=1);

namespace App\Console;

use DI\Container;

class Router
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function run(string $command, ?int $id): void
    {
        $commands = [
            'articles' => \App\Console\Commands\ArticlesCommand::class,
            'article' => \App\Console\Commands\ArticleCommand::class,
            'user' => \App\Console\Commands\UserCommand::class,
        ];

        if (array_key_exists($command, $commands)) {
            $commandClass = $commands[$command];
            $commandInstance = $this->container->get($commandClass);

            if ($id !== null || $command === 'articles') {
                $commandInstance->execute($id);
            } else {
                $this->container->get(\App\Console\Commands\InvalidCommand::class)->execute();
            }
        } else {
            $this->container->get(\App\Console\Commands\InvalidCommand::class)->execute();
        }
    }
}