<?php

namespace App\Console\Commands;

use App\Http\Service\Article\ArticleSourceService;
use Illuminate\Console\Command;

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

//    public function __construct(ArticleSourceService $articleSourceService)
//    {
//        parent::__construct();
//        $this->articleSourceService = $articleSourceService;
//    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
//        $this->info('Fetching articles...');
//        $this->articleSourceService->fetchAndSaveArticles();
//        $this->info('Articles fetched and saved successfully.');
    }
}
