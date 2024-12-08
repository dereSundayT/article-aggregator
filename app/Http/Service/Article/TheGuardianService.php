<?php

namespace App\Http\Service\Article;

use App\Http\Service\ArticleService;
use App\Interfaces\IArticleSource;
use Illuminate\Support\Facades\Log;
use Throwable;

class TheGuardianService implements IArticleSource
{


    protected array $categories = [
        "technology",
        "science",
        "business",
        "healthcare-network",
        "sport",
    ];
    protected int $source_id = 2;



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
                $published_at = date('Y-m-d H:i:s', strtotime($article['webPublicationDate']));
                $cleanedData[] = [
                    'title' => $article['webTitle'],
                    'category_id' => $category_id,
                    'source_id' => $this->source_id,
                    'author_id' => random_int(1, 5),
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


    /**
     * @param string $category
     * @param int $category_id
     * @return array
     */
    public function fetchArticles(string $category, int $category_id): array
    {
        try{

            $token = config('app.guardian_api_token');
            $baseUrl = config('app.guardian_api_url');
            $url = "$baseUrl?api-key=$token&show-fields=all&section=$category";
            $resp = getRequest($url, "");
            if($resp['status'] === "success"){
                $articles = $resp['data']['response']['results'];
                $formatedArticles = $this->formatArticleData($articles,$category_id);
                Log::warning("TheGuardianService: fetchArticles: $category",['total' => count($articles)]);
                return $formatedArticles;
            }
            return [];
        }
        catch (Throwable $throwable){
            storeErrorLog($throwable, "TheGuardianService Error: fetchArticles");
            return [];
        }
    }




    public function getCategories(): array
    {
      return $this->categories;
    }
}
