<?php

namespace App\Listeners;

use App\Events\ArticleView;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticleViewListener
{
    protected $session; // 利用 laravel Session機制去實現數量的統計
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Store  $session) //session 當作緩存機制
    {
        $this->session = $session;  //進來做伺服器緩存
    }

    /**
     * Handle the event.
     *
     * @param  ArticleView  $event
     * @return void
     */
    public function handle(ArticleView $event) // 處理文章瀏覽
    {
        $article = $event->article; //變數  $article  = 該事件的文章

        if( !$this->hasViewedArticle($article ) ){ //查看是否被瀏覽過
            $article->increment('view_count'); //最近沒有瀏覽則瀏覽數加1
            $this->storeViewedArticle($article); //看過文章之後將保存到 session

        }
    }
    public function hasViewedArticle($article) //文章最近是否被瀏覽過
    {
        return array_key_exists($article->id,$this->getViewedArticle($article));
    }
    public function getViewedArticle($article) //如果瀏覽過則獲取session存入的瀏覽記錄
    {
        return $this->session->get('viewed_article', []);
    }
    public function storeViewedArticle($article) //最近第一次瀏覽 存入session
    {
        $key = 'viewed_article.' . $article->id;
        $this->session->put($key, time());
    }
}
