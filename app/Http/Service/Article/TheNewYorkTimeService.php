<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;
use Illuminate\Support\Facades\Log;
use Throwable;

class TheNewYorkTimeService implements IArticleSource
{

    protected array $categories = [
        "technology",
        "science",
        "business",
        "health",
        "sports"
    ];

    protected int $source_id = 3;


    /**
     * @param array $articles
     * @param int $category_id
     * @return array
     */
    public function formatArticleData(array $articles, int $category_id): array
    {
        try{
            $cleanedData = [];
            foreach ($articles as $article) {
                $keywords = !empty($article['des_facet']) ? implode(', ', $article['des_facet']) : '';
                $image = !empty($article['multimedia']) ? $article['multimedia'][0]['url'] : "https://picsum.photos/1000/1000?random=" . mt_rand();
                $title = $article['headline']['main'];
                $content = $article['abstract'];
                if(!empty($title) && !empty($content)){
                    $cleanedData[] = [
                        'title' => $title,
                        'category_id' => $category_id,
                        'source_id' => $this->source_id,
                        'author_id' => random_int(1, 5),
                        'content' => $content,
                        'description' => $content,
                        'keywords' =>$keywords,
                        'image_url' => $image,
                        'published_at' => $article['published_date'],
                    ];
                }

            }
            return $cleanedData;
        }
        catch (Throwable $throwable){
            storeErrorLog($throwable, "TheNewYorkTimes Error: fetchArticles");
            return [];
        }
    }


    /**
     * @param string $category
     * @param int $category_id
     * @return array
     */
    public function fetchArticles(string $category, int $category_id): array
    {
        try{

            $token = config('app.the_new_york_time_api_token');
            $url = config('app.the_new_york_time_api_url') ."/{$category}.json?api-key=$token";

            $resp = getRequest($url, "");
            if($resp['status'] === "success"){
                Log::warning("TheNewYorkTimeService: fetchArticles: $category",[
                    'data' => count($resp['data']['results']),]);
                return $this->formatArticleData($resp['data']['response']['docs'],$category_id);
            }

            return [];
        }
        catch (Throwable $throwable){
            storeErrorLog($throwable, "TheNewYorkTimes Error: fetchArticles");
            return [];
        }
    }




    public function getCategories(): array
    {
        return $this->categories;
    }
}
