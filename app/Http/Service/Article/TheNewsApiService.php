<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class TheNewsApiService implements IArticleSource
{

    protected int $source_id = 1;

    public function formatArticleData($articles): array
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
                        'category_id' => 1,
                        'source_id' => $this->source_id,
                        'author_id' =>1,
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

    public function fetchArticles(): array
    {
        try{

            $token = config('app.news_api_token');
            $baseUrl = config('app.news_api_url');
            $fromDate = '2024-12-01';
            $toDate = '2024-12-02';

            $url = "$baseUrl?country=us&category=sports&from=$fromDate&to=$toDate&sortBy=popularity&apiKey=$token";
            $resp = getRequest($url, "");
            Log::warning("Fetching articles from TheNewsApiService...",[
                'response' => $resp,
                "token" => $token,
                "url" => $url,
                "baseUrl" => $baseUrl
            ]);
            if($resp['status'] === "success"){
                return $this->formatArticleData($resp['data']['articles']);
            }
            return [];
        }
        catch (Throwable $throwable){
            storeErrorLog($throwable, "TheGuardianService Error: fetchArticles");
            return [];
        }
    }

}
