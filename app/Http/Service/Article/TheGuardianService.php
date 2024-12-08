<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;
use Throwable;

class TheGuardianService implements IArticleSource
{

    public function formatArticleData($articles): array
    {
        try{
            $cleanedData = [];
            foreach ($articles as $article) {
                $cleanedData[] = [
                    'title' => $article['webTitle'],
                    'category_id' => $article['category_id'],
                    'source_id' => $article['source_id'],
                    'author_id' => $article['author_id'],
                    'content' => $article['fields']['bodyText'],
                    'description' => $article['fields']['trailText'],
                    'keywords' => $article['fields']['headline'],
                    'image_url' => $article['fields']['thumbnail'],
                    'published_at' => $article['webPublicationDate'],
                ];
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
            $token = config('app.guardian_api_token');
            $baseUrl = config('app.guardian_api_url');
            $url = "$baseUrl?api-key=$token&show-fields=all";
            $resp = getRequest($url, "");
            if($resp['status'] === "success"){
                return $this->formatArticleData($resp['data']['response']['results']);
            }
            return [];
        }
        catch (Throwable $throwable){
            storeErrorLog($throwable, "TheGuardianService Error: fetchArticles");
            return [];
        }
    }
}
