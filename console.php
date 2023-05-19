<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$command = $argv[1];
$id = isset($argv[2]) ? (int)$argv[2] : null;

switch ($command){
    case 'articles' :
        $articlesCommand = new \App\Console\Commands\ArticlesCommand();
        $articlesCommand->execute();
        break;
    case 'article':
        if(!$id){
            \App\Console\Commands\InvalidCommand::execute();
            break;
        }
        $articleCommand = new \App\Console\Commands\ArticleCommand();
        $articleCommand->execute($id);
        break;
    case 'user':
        if(!$id){
            \App\Console\Commands\InvalidCommand::execute();
            break;
        }
        $userCommand = new \App\Console\Commands\UserCommand();
        $userCommand->execute($id);
    break;
    default:
        \App\Console\Commands\InvalidCommand::execute();
        break;
}