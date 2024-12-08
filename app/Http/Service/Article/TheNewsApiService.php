<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class TheNewsApiService implements IArticleSource
{
    protected array $categories = [
        "technology",
        "science",
        "business",
        "health",
        "sports"
    ];
    protected int $source_id = 1;


    /**
     * @param $articles
     * @param $category_id
     * @return array
     */
    public function formatArticleData($articles,$category_id): array
    {
        try{
            $cleanedData = [];
            foreach ($articles as $article) {
                $content = $article['content'];
                $publishedAt = Carbon::createFromFormat('Y-m-d\TH:i:s\Z',$article['publishedAt'])->toDateTimeString();
                $title = $article['title'];
                if($content !== null && $title!=='[Removed]'){
                    $cleanedData[] = [
                        'title' => $article['title'],
                        'category_id' => $category_id,
                        'source_id' => $this->source_id,
                        'author_id' =>random_int(1,5),
                        'content' => $content,
                        'description' => $article['description'],
                        'keywords' => $article['keywords'] ?? null,
                        'image_url' => $article['urlToImage'],
                        'published_at' => $publishedAt,
                    ];
                }
            }
            return $cleanedData;
        }
        catch (Throwable $throwable){
            storeErrorLog($throwable, "TheGuardianService Error: fetchArticles");
            return [];
        }
    }


    /**
     * @param string $category
     * @param int $category_id
     * @return array
     */
    public function fetchArticles(string $category,int $category_id): array
    {
        try{
            $token = config('app.news_api_token');
            $baseUrl = config('app.news_api_url');

            $url = "$baseUrl?country=us&category=$category&sortBy=popularity&apiKey=$token";
            $resp = getRequest($url, "");

            if($resp['status'] === "success"){
                $articles = $resp['data']['articles'];
                $formatedArticles =$this->formatArticleData($articles, $category_id);
                Log::warning("TheNewsApi Service: fetchArticles: $category",['total' => count($articles)]);
                return $formatedArticles;
            }
            return [];
        }
        catch (Throwable $throwable){
            storeErrorLog($throwable, "TheNewsApi Service Error: fetchArticles");
            return [];
        }
    }




    public function getCategories(): array
    {
      return $this->categories;
    }
}
