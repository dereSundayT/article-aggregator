<?php

namespace App\Console\Commands;


use App\Http\Service\Article\TheGuardianService;
use App\Http\Service\Article\TheNewsApiService;
use App\Http\Service\Article\TheNewYorkTimeService;
use App\Http\Service\ArticleService;
use App\Jobs\FetchAndStoreArticlesJob;
use Illuminate\Console\Command;
use Throwable;

class FetchArticlesFromSourcesCommand extends Command
{

    protected $signature = 'app:fetch-articles';

    protected $description = 'Command description';


    public function handle(): void
    {
        $this->info('Start: Fetching and Storing  articles...');
        try{
            $articleService = new ArticleService();
            $articleSources = [
                new TheNewYorkTimeService(),
                new TheGuardianService(),
                new TheNewsApiService(),
            ];

            foreach ($articleSources as $articleSource) {
                foreach ($articleSource->getCategories()  as $index => $categories) {
                    $category_id = $index + 1;
                    FetchAndStoreArticlesJob::dispatch(
                        $articleService,
                        $articleSource,
                        $categories,
                        $category_id);
                }
            }
            $this->info('Jobs dispatched for fetch and store articles from different sources.');
        }catch (Throwable $throwable){
            storeErrorLog($throwable, "Command Error: FetchArticlesFromSourcesCommand");
        }

    }
}
