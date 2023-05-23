<?php declare(strict_types=1);

namespace App\Services\Article\Show;

use App\Models\Comment;
use App\Repositories\Article\JsonPlaceholderArticleRepository;
use App\Repositories\Comment\JsonPlaceholderCommentRepository;
use App\Repositories\User\JsonPlaceholderUserRepository;

class ShowArticleService
{
    private JsonPlaceholderArticleRepository $articleRepository;
    private JsonPlaceholderUserRepository $userRepository;
    private JsonPlaceholderCommentRepository $commentRepository;

    public function __construct(
        JsonPlaceholderArticleRepository $articleRepository,
        JsonPlaceholderUserRepository $userRepository,
        JsonPlaceholderCommentRepository $commentRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
    }

    public function execute(ShowArticleRequest $request): ShowArticleResponse
    {
        $article = $this->articleRepository->getById($request->getArticleId());
        $userId = $article->getUserId();
        $user = $this->userRepository->getById($userId);
        $comments = $this->commentRepository->getByArticleId($request->getArticleId());
        if($request->getCommentName() != null){
            $comments[] = new Comment(
                $request->getArticleId(),
                count($comments) + 1,
                $request->getCommentName(),
                $request->getCommentEmail(),
                $request->getCommentBody()
            );
        }
        return new ShowArticleResponse($article, $user, $comments);
    }
}
