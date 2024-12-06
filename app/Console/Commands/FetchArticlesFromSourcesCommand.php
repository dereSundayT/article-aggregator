<?php

namespace App\Console\Commands;

use App\Http\Service\Article\ArticleSourceService;
use App\Http\Service\Article\TheGuardianService;
use App\Http\Service\Article\TheNewsApiService;
use App\Http\Service\Article\TheNewYorkTimeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class FetchArticlesFromSourcesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected ArticleSourceService $articleSourceService;

    public function __construct()
    {
        parent::__construct();

        $sources = [
            new TheGuardianService(),
            new TheNewsApiService(),
            new TheNewYorkTimeService()
        ];

        $this->articleSourceService = new ArticleSourceService($sources);
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::warning("Fetching articles...");
        $this->info('Fetching articles...');
        try{
            $this->articleSourceService->fetchAndSaveArticles();
            $this->info('Articles fetched and saved successfully.');
        }catch (Throwable $throwable){
            storeErrorLog($throwable, "Command Error: FetchArticlesFromSourcesCommand");
        }

    }
}
