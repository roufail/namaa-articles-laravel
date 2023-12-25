<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use \Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    public function __construct() {
        $this->middleware(['permission:show user']); 
        $this->middleware(['permission:create user'],['only' => ['create','store']]); 
        $this->middleware(['permission:edit user'],['only' => ['edit','update']]); 
        $this->middleware(['permission:delete user'],['only' => ['destroy']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id','name','email','created_at')->with('roles:name,id')->withCount('articles')->orderbyDesc('created_at')->paginate(10);
        return view('admin.users.index',compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        $roles    = Role::select('id','name')->get()->pluck('name','id');
        return view('admin.users.form',compact('user','roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $request->merge(['password' => bcrypt($request->password)]);
        if($user = User::create($request->only('name','email','password'))) {
            if(auth()->user()->can('change user role')){
                if(isset($request->role)) 
                {
                    $user->assignRole($request->role);
                } else {
                    $user->syncRoles([]);
                }
            }
            return redirect()->route('admin.users.index')->with(['success' => 'user saved succesfully']);
        }else {
            return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if($user) {
          $roles    = Role::select('id','name')->get()->pluck('name','id');
          return view('admin.users.form',compact('user','roles'));
        }
        return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        if(!isset($request->password)) {
            $request->request->remove('password');
        }
        if($user) {
            if($user->update($request->all())) {
                if(auth()->user()->can('change user role')){
                    if(isset($request->role)) 
                    {
                        $user->assignRole($request->role);
                    } else {
                        $user->syncRoles([]);
                    }
                }
                return redirect()->route('admin.users.index')->with(['success' => 'user updated succesfully']);
            }
        }
        return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        if($user) {
            if($user->delete()) {
                return redirect()->route('admin.users.index')->with(['success' => 'user deleted succesfully']);
            }

        }
        return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function userArticles(User $user)
    {
        $articles = $user->articles()->select('id','title','approved','user_id','created_at')->with('user:id,name')->paginate(10);
        return view('admin.articles.index',compact('articles'));
    }
}
