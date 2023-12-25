<?php

namespace App\Observers;

use App\Models\Admin\Article;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewArticleNotification;
class ArticleObserver
{


    /**
     * Handle the Article "updating" event.
    */
    public function updating(Article $article) {
        $article->content = clean($article->content);
    }

    /**
     * Handle the Article "creating" event.
    */
    public function creating(Article $article) {
        $article->content = clean($article->content);
    }

    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {


        $users = User::whereHas('permissions', function ($query) {
                $query->where('name', 'approve article');
            })->orWhereHas('roles.permissions', function ($query) {
                $query->where('name', 'approve article');
            })
            ->get();
        if(!$article->approved) {
            Notification::send($users, new NewArticleNotification($article));
        }
        
        $this->forgetCaches('articles_page_');
    }

    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article): void
    {
        $this->forgetCaches('articles_page_');
    }

    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        $this->forgetCaches('articles_page_');
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        $this->forgetCaches('articles_page_');
    }

    /**
     * Handle the Article "force deleted" event.
     */
    public function forceDeleted(Article $article): void
    {
        $this->forgetCaches('articles_page_');
    }


    public static function forgetCaches($prefix)
    {
        // Increase loop if you need, the loop will stop when key not found
        for ($i=1; $i < 1000; $i++) {
            $key = $prefix . $i;
            if (Cache::has($key)) {
                Cache::forget($key);
            } else {
                break;
            }
        }
    }
}
