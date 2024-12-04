<?php

namespace App\Interfaces;

interface IArticleSource
{
    //
    public function getArticles(string $source, array $filters): array;

}
