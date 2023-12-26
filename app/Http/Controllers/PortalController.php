<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Article;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class PortalController extends Controller
{
    public function index(Request $request) {
        $page = $request->has('page') ? $request->query('page') : 1;
        $articles = Cache::rememberForever('articles_page_'.$page, function () {
            return Article::Approved()->with('user:name,id')->select('id','title','created_at','excerpt','user_id')->paginate(10);
        });
        return view('portal.articles.index',compact('articles'));
    }

    public function search(Request $request) {
        $articles = Article::where('content','like','%'.$request->search.'%')->orWhere('title','like','%'.$request->search.'%')
                    ->Approved()->with('user:name,id')
                    ->select('id','title','created_at','excerpt','user_id')->paginate(10);
        return view('portal.articles.index',compact('articles'));
    }


    public function article(Article $article) {
        if(!$article->approved) abort(404);
        $article->load('approvedcomments.user');
        return view('portal.articles.show',compact('article'));
    }
    public function author_articles(User $user) {
        $articles =  $user->articles()->paginate(10);
        return view('portal.articles.index',compact('articles'));
    }

    public function comment(Request $request, Article $article){
        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:15'
        ]);

        $request->merge(['user_id' => auth()->user()->id]);
        // clean value from javascript XSS this function in app/helpers.php
        $request->merge(['content' => cleanXSSValue($request->content)]);

        $comment = $article->comments()->create($request->all());
        if($comment) {
            return redirect()->back()->with(['success' => 'comment added successfully waiting for approvement']);
        }
        return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }

}
