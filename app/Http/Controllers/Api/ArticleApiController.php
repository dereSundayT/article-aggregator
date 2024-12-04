<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetArticlesRequest;
use App\Http\Service\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleApiController extends Controller
{
    public function __construct(protected ArticleService $articleService)
    {
    }

    public function getArticles(GetArticlesRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $articles = $this->articleService->getArticleService(
                $validated['keyword'] ?? null,
                $validated['start_date'] ?? null,
                $validated['end_date'] ?? null,
                $validated['category_ids'] ?? [],
                $validated['source_ids'] ?? [],
                $validated['author_ids'] ?? []
            );

            return successResponse("Articles fetched successfully", $articles);
        } catch (\Throwable $th) {
            storeErrorLog($th, 'ArticleApiController Exception:');
            return errorResponse("An error occurred while fetching articles", 500);
        }
    }
}
