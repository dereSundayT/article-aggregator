<?php

namespace App\Interfaces;

interface IArticleSource
{
    //
    public function formatArticleData($articles): array;
    public function fetchArticles(): array;

}
