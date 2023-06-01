<?php declare(strict_types=1);

namespace App\Controllers;

use App\Redirect;
use App\Services\Comment\Create\CreateCommentRequest;
use App\Services\Comment\Create\CreateCommentService;
use App\Services\Comment\Delete\DeleteCommentRequest;
use App\Services\Comment\Delete\DeleteCommentService;
use App\SessionManager;

class CommentController
{
    private CreateCommentService $createCommentService;
    private DeleteCommentService $deleteCommentService;

    public function __construct(
        CreateCommentService $createCommentService,
        DeleteCommentService $deleteCommentService)
    {

        $this->createCommentService = $createCommentService;
        $this->deleteCommentService = $deleteCommentService;
    }

    public function store(array $variables): Redirect
    {
        $articleId = (int)$variables['id'];
        $this->createCommentService->execute(new CreateCommentRequest(
            $articleId,
            SessionManager::get(),
            $_POST['body']
        ));
        return new Redirect("/article/$articleId");
    }

    public function delete(array $variables):Redirect
    {
        $articleId = (int)$variables['id'];
        $commentId = (int)$variables['commentId'];
        $this->deleteCommentService->execute(new DeleteCommentRequest($commentId));

        return new Redirect("/article/$articleId");
    }
}