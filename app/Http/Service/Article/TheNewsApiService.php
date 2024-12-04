<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;

class TheNewsApiService implements IArticleSource
{

    public function getArticles(string $source, array $filters): array
    {
        // TODO: Implement fetchArticles() method.
        // https://newsapi.org/
        return [];
    }
}
