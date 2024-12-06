<?php

namespace App\Http\Service;

use App\Models\Author;
use App\Models\Category;
use App\Models\Source;


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
}
