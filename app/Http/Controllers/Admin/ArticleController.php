<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Admin\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function __construct() {
        $this->middleware(['permission:show article']); 
        $this->middleware(['permission:create article'],['only' => ['create','store']]); 
        $this->middleware(['permission:edit article'],['only' => ['edit','update']]); 
        $this->middleware(['permission:delete article'],['only' => ['destroy']]); 
        $this->middleware(['permission:approve article'],['only' => ['approve']]); 
        $this->middleware(['permission:reject article'],['only' => ['reject']]); 
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $articles = Article::query();
        if(!auth()->user()->can('show others articles')){
            $articles = $articles->where('user_id', auth()->user()->id);
        }
        $articles = $articles->select('articles.id','title','approved','user_id','created_at')->with('user:users.id,name');
        if($request->has('sort_by')) {
            if($request->sort_by == 'user') {
                $articles = $articles->select('articles.id','title','approved','user_id','articles.created_at','users.name')->with('user:id,name');
                $articles = $articles->join('users', 'users.id', '=', 'articles.user_id')
                ->orderBy('users.name', $request->sort);
            }else {
                $articles = $articles->orderby($request->sort_by,$request->sort);
            }
        }else {
            $articles = $articles->orderbyDesc('created_at');
        }
        $articles = $articles->paginate(10);
        return view('admin.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $article = new Article();
        return view('admin.articles.form',compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {

        if(auth()->user()->can('approve article')){
           $request->merge(['approved' => 1]);
        }

        if($article = auth()->user()->articles()->create($request->all())) {
            return redirect()->route('admin.articles.index')->with(['success' => 'article saved succesfully']);
        }else {
            return redirect()->back()->withErrors(['Error' => 'sometthing went wrong!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {

        if(!$this->checkUserPermissions(['edit article','edit others articles'], $article)){
            return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
        }

        if($article) {
          return view('admin.articles.form',compact('article'));
        }
        return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        if($article) {
            if(!$this->checkUserPermissions(['edit article','edit others articles'], $article)){
                return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
            }
            if($article->update($request->all())) {
                return redirect()->route('admin.articles.index')->with(['success' => 'Article updated succesfully']);
            }
        }
        return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if($article) {
            if(!$this->checkUserPermissions(['delete article','delete others articles'], $article)){
                return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
            }
            if($article->delete()) {
                return redirect()->route('admin.articles.index')->with(['success' => 'Article deleted succesfully']);
            }
        }
        return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }


        /**
     * Update the specified resource in storage.
     */
    public function approve(Request $request, Article $article)
    {
        if($article) {
            if(!$this->checkUserPermissions(['approve article','approve others articles'], $article)){
                return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
            }
            if($article->update(['approved' => 1])) {
              return redirect()->back()->with(['success' => 'article approved succesfully']);
            }
        }
        return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }

        /**
     * Update the specified resource in storage.
     */
    public function reject(Request $request, Article $article)
    {
        if($article) {
            if(!$this->checkUserPermissions(['reject article','reject others articles'], $article)){
                return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
            }
            if($article->update(['approved' => 0])) {
                return redirect()->back()->with(['success' => 'article rejected succesfully']);
            }
        }
        return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }

}
