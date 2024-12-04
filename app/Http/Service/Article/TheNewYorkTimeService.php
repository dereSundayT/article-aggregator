<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;

class TheNewYorkTimeService implements IArticleSource
{

    public function getArticles(string $keyword, array $filters): array
    {
        // TODO: Implement getArticles() method.
        return [];
    }
}
