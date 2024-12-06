<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Service\GeneralService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeneralApiController extends Controller
{
    public function __construct(protected GeneralService $generalService)
    {
    }


    /**
     * Get article sources
     * @return JsonResponse
     */
    public function getArticleSources(): JsonResponse
    {
        try{
           $articleSources =  $this->generalService->getAllSourceService();
           return successResponse("Article sources fetched successfully", $articleSources);
        }
        catch (\Throwable $th) {
            storeErrorLog($th,"Controller Error: GeneralApiController->getArticleSources");
            return errorResponse("An error occurred while fetching articles", 500);
        }
    }

    /**
     * Get article categories
     * @return JsonResponse
     */
    public function getArticleCategories(): JsonResponse
    {
        try{
            $categories =  $this->generalService->getAllCategoryService();
            return successResponse("Article categories fetched successfully", $categories);
        }
        catch (\Throwable $th) {
            storeErrorLog($th,"Controller Error: GeneralApiController->getCategories");
            return errorResponse("An error occurred while fetching categories", 500);
        }
    }

    /**
     * Get article authors
     * @return JsonResponse
     */
    public function getArticleAuthors(): JsonResponse
    {
        try{
            $authors =  $this->generalService->getAllAuthorService();
            return successResponse("Article authors fetched successfully", $authors);
        }
        catch (\Throwable $th) {
            storeErrorLog($th,"Controller Error: GeneralApiController->getAuthors");
            return errorResponse("An error occurred while fetching authors", 500);
        }
    }
}
