<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\Comment\DeleteCommentRequest;
use App\Services\Comment\StoreCommentRequest;
use App\Services\Comment\ModifyCommentService;

class CommentController
{
    private ModifyCommentService $modifyCommentService;

    public function __construct(ModifyCommentService $modifyCommentService)
    {
        $this->modifyCommentService = $modifyCommentService;
    }

    public function store(array $variables): void
    {
        $articleId = (int)$variables['id'];
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['body'])) {
            $this->modifyCommentService->store(new StoreCommentRequest(
                $articleId,
                $_POST['name'],
                $_POST['email'],
                $_POST['body']
            ));
        }
        header("Location: /article/$articleId");
    }
    public function delete(array $variables): void
    {
        $articleId = (int)$variables['id'];
        $commentId = (int)$variables['commentId'];
        $this->modifyCommentService->delete(new DeleteCommentRequest($articleId, $commentId));

        header("Location: /article/$articleId");
    }
}