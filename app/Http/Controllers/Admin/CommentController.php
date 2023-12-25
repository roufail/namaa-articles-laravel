<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Admin\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct() {
        $this->middleware(['permission:show comment']); 
        $this->middleware(['permission:create comment'],['only' => ['create','store']]); 
        $this->middleware(['permission:edit comment'],['only' => ['edit','update']]); 
        $this->middleware(['permission:delete comment'],['only' => ['destroy']]); 
        $this->middleware(['permission:approve comment'],['only' => ['approve']]); 
        $this->middleware(['permission:reject comment'],['only' => ['reject']]); 
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $comments = Comment::with(['user:id,name','article:id,title']);

        if($request->has('sort_by')) {
            if($request->sort_by == 'user') {
                $comments = $comments->join('users', 'users.id', '=', 'comments.user_id')->orderBy('users.name', $request->sort);
            }
            elseif($request->sort_by == 'article') {
                $comments = $comments->join('articles', 'comments.article_id', '=', 'articles.id')->orderBy('articles.title', $request->sort);
            }
            else {
                $comments = $comments->orderby($request->sort_by,$request->sort);
            }

        }else {
            $comments = $comments->orderbyDesc('created_at');
        }
        $comments = $comments->paginate(10);
        return view('admin.comments.index',compact('comments'));

    }




    /**
     * Update the specified resource in storage.
     */
    public function approve(UpdateCommentRequest $request, Comment $comment)
    {
        if($comment && $comment->update(['approved' => 1])) {
          return redirect()->back()->with(['success' => 'Comments approved succesfully']);
        }
        return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }

        /**
     * Update the specified resource in storage.
     */
    public function reject(UpdateCommentRequest $request, Comment $comment)
    {
        if($comment && $comment->update(['approved' => 0])) {
            return redirect()->back()->with(['success' => 'comment rejected succesfully']);
          }
          return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
      }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {

        if($comment && $comment->delete()) {
            return redirect()->route('admin.comments.index')->with(['success' => 'Comments rejected succesfully']);
          }
          return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }
}
