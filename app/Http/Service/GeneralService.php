<?php

namespace App\Http\Service;

use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;


class GeneralService
{

    /**

     */
    public function getAllCategoryService(): ?object
    {
        try{
            return Category::select(['id','name'])->get();
        }
        catch (\Throwable $th) {
            storeErrorLog($th,"Service Error: GeneralService->getCategories");
            return null;
        }
    }


    public function getAllAuthorService(): ?object
    {
        try{
            return Author::select(['id','name'])->get();
        }
        catch (\Throwable $th) {
            storeErrorLog($th,"Service Error: GeneralService->getAuthors");
            return null;
        }
    }

    public function getAllSourceService(){
        try{
            return  Source::select(['id','name'])->get();
        }catch (\Throwable $th) {
            storeErrorLog($th,"Service Error: GeneralService->getSources");
            return null;
        }
    }





    /**
     * Authorize an action for the given ability and model.
     *
     * @param string $ability
     * @param string $model
     * @throws AuthorizationException
     */
    public function authorizeAction(string $ability, string $model): void
    {
        $response = Gate::inspect($ability, $model);
        if (!$response->allowed()) {
            throw new AuthorizationException($response->message(),403);
        }
    }
}
