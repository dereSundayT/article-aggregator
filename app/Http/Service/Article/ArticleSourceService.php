<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;
use App\Models\Article;

class ArticleSourceService
{
    protected array $sources;

    /**
     * Inject all services that implement NewsSourceInterface.
     *
     * @param  array<IArticleSource>  $sources
     */
    public function __construct(array $sources)
    {
        $this->sources = $sources;
    }
    public function fetchAndSaveArticles(): void
    {
        foreach ($this->sources as $source) {
            $articles = $source->fetchArticles();

//            foreach ($articles as $article) {
//                Article::updateOrCreate(
//                    ['title' => $article['title']],
//                    [
//                        'description' => $article['description'],
//                        'content' => $article['content'],
//                        'keywords' => $article['keywords'] ?? null,
//                        'image_url' => $article['urlToImage'] ?? null,
//                        'source' => $article['source']['name'] ?? 'Unknown',
//                        'published_at' => $article['publishedAt'],
//                    ]
//                );
//            }
        }
    }

}
