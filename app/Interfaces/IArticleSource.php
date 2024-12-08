<?php

namespace App\Interfaces;

interface IArticleSource
{
    //

    public function getCategories();
    public function formatArticleData(array $articles,int $category_id): array;
    public function fetchArticles(string $category,int $category_id): array;


}
