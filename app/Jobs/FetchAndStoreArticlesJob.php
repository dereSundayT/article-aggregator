<?php

namespace App\Jobs;

use App\Http\Service\ArticleService;
use App\Interfaces\IArticleSource;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchAndStoreArticlesJob implements ShouldQueue
{
    use Queueable;



    public function __construct(
        protected ArticleService $articleService,
        protected IArticleSource $iArticleSource,
        protected string $category,
        protected int $category_id)
    {


    }



    /**
     * Execute the job.
     */
    public function handle(): void
    {

       $articles=  $this->iArticleSource->fetchArticles($this->category,$this->category_id);
       if (!empty($articles)) {
           foreach ($articles as $article){
               $this->articleService->saveArticlesService($article);
           }
       }


    }
}
