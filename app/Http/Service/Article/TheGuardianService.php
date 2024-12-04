<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;

class TheGuardianService implements IArticleSource
{

    public function getArticles(string $keyword, array $filters): array
    {
        //https://open-platform.theguardian.com/documentation/search
        // TODO: Implement getArticles() method.
        return [];
    }
}
