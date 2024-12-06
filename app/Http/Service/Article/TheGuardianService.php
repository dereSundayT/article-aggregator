<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;

class TheGuardianService implements IArticleSource
{


    public function fetchArticles(): array
    {
        return [];
    }
}
