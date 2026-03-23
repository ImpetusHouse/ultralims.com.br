<?php

namespace App\Console\Commands;


use \Illuminate\Support\Facades\URL;
use Illuminate\Console\Command;

use App\Models\Articles\Article;
use App\Models\Pages\Page;


class Sitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            //Cria o objeto Sitemap
            $sitemap = resolve("sitemap");

            //Adiciona itens para o sitemap (url, date, priority, freq)
            $sitemap->add(URL::to('/'), \Carbon\Carbon::now(), '1.0', 'daily');
            $sitemap->add(URL::to('/blog'), \Carbon\Carbon::now(), '1.0', 'daily');

            //Adiciona todas as páginas
            $pages = Page::where('status', true)->orderBy('title')->get();
            foreach ($pages as $page){
                $url = '';
                if ($page->prefix_slug->count() > 0) {
                    $url .= implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
                }
                $url .= $page->slug;
                $sitemap->add(URL::to('/'.$url), $page->updated_at, '1.0', 'daily');
            }

            //Adiciona todas as publicações
            $articles = Article::where('status', 'published')->get();
            foreach ($articles as $article){
                $sitemap->add(URL::to('/blog/'.$article->slug), $article->updated_at, '1.0', 'daily');
            }

            //Adiciona os grupos de análise caso for o PróLab
            if (env('APP_NAME') == 'PróLab') {
                $analysisGroups = \App\Models\PróLab\AnalysisGroup::orderBy('name')->get();
                foreach ($analysisGroups as $analysisGroup) {
                    $sitemap->add(URL::to('/analise/' . $analysisGroup->slug), $analysisGroup->updated_at, '1.0', 'daily');
                }
            }

            //Gera p sitemap (format, filename)
            $sitemap->store('xml', 'sitemap');
            dump('Sitemap gerado com sucesso!');
            return 200;
        }catch (\Exception $e){
            dump($e->getMessage());
            return 500;
        }
    }
}
