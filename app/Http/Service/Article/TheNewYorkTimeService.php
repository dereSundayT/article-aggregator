<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;
use Throwable;

class TheNewYorkTimeService implements IArticleSource
{

    protected int $source_id = 3;
    protected int $author_id =2;
    protected int $category_id = 1;

    public function formatArticleData($articles): array
    {
        try{
            $cleanedData = [];
            foreach ($articles as $article) {
                $keywords = !empty($article['des_facet']) ? implode(', ', $article['des_facet']) : '';
                $image = !empty($article['multimedia']) ? $article['multimedia'][0]['url'] : "https://picsum.photos/1000/1000?random=" . mt_rand();

                $cleanedData[] = [
                    'title' => $article['title'],
                    'category_id' => $this->category_id,
                    'source_id' => $this->source_id,
                    'author_id' => $this->author_id,
                    'content' => $article['abstract'],
                    'description' => $article['abstract'],
                    'keywords' =>$keywords,
                    'image_url' => $image,
                    'published_at' => $article['published_date'],
                ];
            }
            return $cleanedData;
        }
        catch (Throwable $throwable){
            storeErrorLog($throwable, "TheNewYorkTimes Error: fetchArticles");
            return [];
        }
    }


    public function fetchArticles(): array
    {
        try{

            $category = "technology";
            $token = config('app.the_new_york_time_api_token');
            $baseUrl = config('app.the_new_york_time_api_url') ."/{$category}.json";
            $url = "$baseUrl?api-key=$token";
            $resp = getRequest($url, "");
            if($resp['status'] === "success"){
                return $this->formatArticleData($resp['data']['results']);
            }
            return [];
        }
        catch (Throwable $throwable){
            storeErrorLog($throwable, "TheNewYorkTimes Error: fetchArticles");
            return [];
        }
    }
}
