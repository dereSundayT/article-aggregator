<?php

namespace App\Http\Service;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;

class ArticleService
{
    public function __construct()
    {
    }


    /**
     * @description Get articles
     * @param $keyword
     * @param $start_date
     * @param $end_date
     * @param $category_ids
     * @param $source_ids
     * @param $author_ids
     * @return LengthAwarePaginator|array
     */
    public function getArticleService($keyword, $start_date, $end_date, $category_ids, $source_ids, $author_ids): ?LengthAwarePaginator
    {
        try {
            return Article::query()
                ->when(!empty($keyword), function ($query) use ($keyword) {
                    $query->where('title', 'like', "%$keyword%")
                        ->orWhere('keywords', 'like', "%$keyword%")
                        ->orWhere('content', 'like', "%$keyword%");
                })
                ->when(!empty($start_date), function ($query) use ($start_date) {
                    $query->whereDate('published_at', '>=', $start_date);
                })
                ->when(!empty($end_date), function ($query) use ($end_date) {
                    $query->whereDate('published_at', '<=', $end_date);
                })
                ->when(!empty($source_ids), function ($query) use ($source_ids) {
                    $query->whereIn('source_id', $source_ids);
                })
                ->when(!empty($category_ids), function ($query) use ($category_ids) {
                    $query->whereIn('category_id', $category_ids);
                })
                ->when(!empty($author_ids), function ($query) use ($author_ids) {
                    $query->whereIn('author_id', $author_ids);
                })
                ->paginate(10);

        } catch (Throwable $th) {
            storeErrorLog($th, 'ArticleApiController Exception:');
            return null;
        }
    }

}
