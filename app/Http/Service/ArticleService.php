<?php

namespace App\Http\Service;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class ArticleService
{
    public function __construct()
    {
    }


    /**
     * @param string $article_id
     * @return ArticleResource|null
     */
    public function getArticleDetailService(string $article_id): ArticleResource | null
    {
        try{
          $article =  Article::where('id', $article_id)->first();
          if($article){
              return  new ArticleResource($article);
          }

        }
        catch (Throwable $th) {
            storeErrorLog($th, 'ArticleService Exception:');
        }
        return null;
    }
    public function getUserArticlePreferenceService($user): ?LengthAwarePaginator
    {
        try{

            $category_ids = $user->categories->pluck('id')->toArray();
            $source_ids = $user->sources->pluck('id')->toArray();
            $author_ids = $user->authors->pluck('id')->toArray();
            if(empty($category_ids) && empty($source_ids) && empty($author_ids)){
                return null;
            }
            return $this->getArticleService(null,null,null,$category_ids,$source_ids,$author_ids);
        }
        catch (Throwable $th) {
            storeErrorLog($th, 'ArticleService Exception:');
            return null;
        }

    }


    /**
     * @description Get articles
     * @param $keyword
     * @param $start_date
     * @param $end_date
     * @param $category_ids
     * @param $source_ids
     * @param $author_ids
     * @return LengthAwarePaginator|null
     */
    public function getArticleService($keyword, $start_date, $end_date, $category_ids, $source_ids, $author_ids): ?LengthAwarePaginator
    {
        try {
            $start_date = returnDate($start_date);
            $end_date = returnDate($end_date);
            return Article::with([
                'source:id,name',
                'category:id,name',
                'author:id,name,image_url,role',
            ])
                ->when(!empty($keyword), function ($query) use ($keyword) {
                    $query->where('title', 'like', "%$keyword%");
//                        ->orWhere('keywords', 'like', "%$keyword%")
//                        ->orWhere('content', 'like', "%$keyword%");
                })
                ->when(!empty($start_date), function ($query) use ($start_date) {
                    $query->whereDate('created_at', '>=', $start_date);
                })
                ->when(!empty($end_date), function ($query) use ($end_date) {
                    $query->whereDate('created_at', '<=', $end_date);
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
                ->orderBy('created_at', 'desc')
                ->paginate(10);


        } catch (Throwable $th) {
            storeErrorLog($th, 'ArticleApiController Exception:');
            return null;
        }
    }


    public function saveArticlesService($article): void{
        try{
            Article::updateOrCreate(
                [
                    'title' => $article['title'],
                    'category_id' => $article['category_id'],
                    'source_id' => $article['source_id'],
                    'author_id' => $article['author_id'],
                    'published_at' => $article['published_at']
                ],
                [
                    'content' => $article['content'],
                    'description' => $article['description'],
                    'keywords' => $article['keywords'],
                    'image_url' => $article['image_url'],
                ]
            );
        }catch (Throwable $throwable){
            storeErrorLog($throwable, "ArticleSourceService Error: saveArticles");
        }

    }



}
