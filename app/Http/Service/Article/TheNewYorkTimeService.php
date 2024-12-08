<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;
use Throwable;

class TheNewYorkTimeService implements IArticleSource
{

    protected int $source_id = 3;

    public function formatArticleData($articles): array
    {
        try{
            $cleanedData = [];
            foreach ($articles as $article) {
                $cleanedData[] = [
                    'title' => $article['title'],
                    'category_id' => $article['category_id'],
                    'source_id' => $this->source_id,
                    'author_id' => $article['author_id'],
                    'content' => $article['content'],
                    'description' => $article['description'],
                    'keywords' => $article['keywords'],
                    'image_url' => $article['image_url'],
                    'published_at' => $article['published_at'],
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
            return [];
        }
        catch (Throwable $throwable){
            storeErrorLog($throwable, "TheGuardianService Error: fetchArticles");
            return [];
        }
    }
}
