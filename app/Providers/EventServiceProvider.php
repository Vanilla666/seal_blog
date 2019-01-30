<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [   //生成事件監聽的地方
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\ArticleView' => [ //生成文章瀏覽的監聽事件
            'App\Listeners\ArticleViewListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
