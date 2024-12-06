<?php

namespace App\Http\Service\Article;

use App\Interfaces\IArticleSource;
use App\Models\Article;
use Throwable;

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


    public function saveArticles($article): void{
        try{
            Article::updateOrCreate(
                [
                    'title' => $article['title'],
                    'category_id' => $article['category_id'],
                    'source_id' => $article['source_id'],
                    'author_id' => $article['author_id'],
                ],
                [
                    'content' => $article['content'],
                    'description' => $article['description'],
                    'keywords' => $article['keywords'],
                    'image_url' => $article['image_url'],
                    'published_at' => $article['published_at'],
                ]
            );
        }catch (Throwable $throwable){
            storeErrorLog($throwable, "ArticleSourceService Error: saveArticles");
        }

    }


    /*
     * Fetch articles from all sources and save them to the database.
     */
    public function fetchAndSaveArticles(): void
    {
        foreach ($this->sources as $source) {

            $articles = $source->fetchArticles();

            foreach ($articles as $article) {
                $this->saveArticles($article);

            }
        }
    }

}
