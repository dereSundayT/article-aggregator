<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetArticlesRequest;
use App\Http\Service\Article\ArticleSourceService;
use App\Http\Service\Article\TheGuardianService;
use App\Http\Service\Article\TheNewsApiService;
use App\Http\Service\Article\TheNewYorkTimeService;
use App\Http\Service\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ArticleApiController extends Controller
{
    public function __construct(protected ArticleService $articleService)
    {
    }

    /**
     * @description Get articles
     * @param GetArticlesRequest $request
     * @return JsonResponse
     */
    public function getArticles(GetArticlesRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            // unique cache key using the request parameters
            $cacheKey = 'articles_' . md5(json_encode($validated, JSON_THROW_ON_ERROR));

            // Check if the articles are already cached, the cache will be stored for 1 hour
            $articles = cache()->remember($cacheKey, 3600, function () use ($validated) {
                $articles = $this->articleService->getArticleService(
                    $validated['keyword'] ?? null,
                    $validated['start_date'] ?? null,
                    $validated['end_date'] ?? null,
                    $validated['category_ids'] ?? [],
                    $validated['source_ids'] ?? [],
                    $validated['author_ids'] ?? []
                );
                // cache articles if they are not empty
                if (!empty($articles)) {
                    return $articles;
                }
                return null;
            });

            return successResponse("Articles fetched successfully", $articles);
        } catch (Throwable $th) {
            storeErrorLog($th, 'ArticleApiController Exception:');
            return errorResponse("An error occurred while fetching articles", 500);
        }
    }


    public function test()
    {
        $r = new ArticleSourceService([
//            new TheGuardianService(),
            new TheNewsApiService(),
//            new TheNewYorkTimeService()
        ]);
        $r->fetchAndSaveArticles();
        return "done";
    }


}
