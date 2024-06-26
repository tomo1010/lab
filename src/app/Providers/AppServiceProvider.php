<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)//引数の設定はフォームからhttpsへリンクするため
    {
        //
        Paginator::useBootstrap();

        $url->forceScheme('https'); //フォームからhttpsへリンクするため

    }
    
}
