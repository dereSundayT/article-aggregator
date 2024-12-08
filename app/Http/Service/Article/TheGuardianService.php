<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;
use Illuminate\Support\Facades\Log;
use Throwable;

class TheGuardianService implements IArticleSource
{

    protected int $source_id = 2;
    protected int $category_id = 1;
    protected int $author_id = 1;

    public function formatArticleData($articles): array
    {
        try{
            $cleanedData = [];
            foreach ($articles as $article) {
                //'published_at' => (new \DateTime($article['webPublicationDate']))->format('Y-m-d H:i:s'),
                $published_at = date('Y-m-d H:i:s', strtotime($article['webPublicationDate']));
                $cleanedData[] = [
                    'title' => $article['webTitle'],
                    'category_id' => $this->category_id,
                    'source_id' => $this->source_id,
                    'author_id' => $this->author_id,
                    'content' => $article['fields']['bodyText'],
                    'description' => $article['fields']['trailText'],
                    'keywords' => $article['fields']['headline'],
                    'image_url' => $article['fields']['thumbnail'],
                    'published_at' => $published_at,
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
