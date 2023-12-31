<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Article;
use App\Http\Resources\Api\ArticleCollection;
use App\Http\Resources\Api\ArticleResource;
class ArticleController extends Controller
{
    public function articles(Request $request){
        $articles = Article::approved();
        if($request->has('search')) {
            $articles = $articles->where('title','like', '%'.$request->search.'%')->orwhere('content','like', '%'.$request->search.'%');
        }
        $articles = $articles->select('id','title','approved','user_id','created_at')->with(['user:id,name'])->orderbyDesc('created_at')->paginate(10);
        return  $this->success(new ArticleCollection($articles),'Articles Retrived Successfully');
    }

    public function article(Article $article){
        $article->load(['user:id,name','approvedcomments']);
        return  $this->success(new ArticleResource($article),'Article Retrived Successfully');
    }

}
