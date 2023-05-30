<?php declare(strict_types=1);

namespace App\Services\Article\Update;

use App\Repositories\Article\ArticleRepository;

class UpdateArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(UpdateArticleRequest $request): UpdateArticleResponse
    {
        $article = $this->articleRepository->getById($request->getArticleId());
        $article->update(
            [
                'title' => $request->getTitle(),
                'body' => $request->getBody()
            ]
        );
        $this->articleRepository->update($article);
        return new UpdateArticleResponse($article);
    }
}
