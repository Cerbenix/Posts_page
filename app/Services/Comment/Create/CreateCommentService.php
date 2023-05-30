<?php declare(strict_types=1);

namespace App\Services\Comment\Create;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\User\UserRepository;

class CreateCommentService
{
    private CommentRepository $commentRepository;
    private UserRepository $userRepository;

    public function __construct(
        CommentRepository $commentRepository,
        UserRepository $userRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
    }
    public function execute(CreateCommentRequest $request): void
    {
        $user = $this->userRepository->getById($request->getUserId());
        $comment = new Comment(
            $request->getArticleId(),
            $user->getName(),
            $user->getEmail(),
            $request->getBody()
        );

        $this->commentRepository->save($comment);
    }
}
