<?php declare(strict_types=1);

namespace App\Services\Comment;

use App\Repositories\Comment\CommentRepository;

class ModifyCommentService
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(StoreCommentRequest $request): void
    {
        $this->commentRepository->store(
            $request->getArticleId(),
            $request->getName(),
            $request->getEmail(),
            $request->getBody()
        );
    }
    public function delete(DeleteCommentRequest $request):void
    {
        $this->commentRepository->delete($request->getArticleId(), $request->getCommentId());
    }
}
