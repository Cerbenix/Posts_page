<?php declare(strict_types=1);

namespace App\Services\Article\Create;

use App\Repositories\Article\ArticleRepository;

class CreateArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(CreateArticleRequest $request): CreateArticleResponse
    {
        $isSaved = $this->articleRepository->create($request->getTitle(), $request->getBody());
        return New CreateArticleResponse($isSaved);
    }
}
