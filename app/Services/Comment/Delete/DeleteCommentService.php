<?php declare(strict_types=1);

namespace App\Services\Comment\Delete;

use App\Repositories\Comment\CommentRepository;

class DeleteCommentService
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
    public function execute(DeleteCommentRequest $request):void
    {
        $this->commentRepository->delete($request->getCommentId());
    }
}