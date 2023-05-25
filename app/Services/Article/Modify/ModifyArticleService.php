<?php declare(strict_types=1);

namespace App\Services\Article\Modify;

use App\Repositories\Article\ArticleRepository;

class ModifyArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {

        $this->articleRepository = $articleRepository;
    }

    public function update(UpdateArticleRequest $request): UpdateArticleResponse
    {
        $isSaved = $this->articleRepository->update(
            $request->getArticleId(),
            $request->getTitle(),
            $request->getBody());
        return new UpdateArticleResponse($isSaved);
    }

    public function delete(int $articleId): void
    {
        $this->articleRepository->delete($articleId);
    }

    public function create(CreateArticleRequest $request): CreateArticleResponse
    {
        $isSaved = $this->articleRepository->create($request->getTitle(), $request->getBody());
        return new CreateArticleResponse($isSaved);
    }


}
