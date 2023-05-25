<?php declare(strict_types=1);

namespace App\Services\Article\Update;

use App\Repositories\Article\ArticleRepository;
use App\Services\Article\Create\CreateArticleResponse;

class UpdateArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(UpdateArticleRequest $request):UpdateArticleResponse
    {
        $isSaved = $this->articleRepository->update(
            $request->getArticleId(),
            $request->getTitle(),
            $request->getBody());
        return new UpdateArticleResponse($isSaved);
    }
}