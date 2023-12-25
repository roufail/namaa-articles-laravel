<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use \Spatie\Permission\Models\Permission;
use App\Models\User;
class RoleController extends Controller
{

    public function __construct() {
        $this->middleware(['permission:show role']); 
        $this->middleware(['permission:create role'],['only' => ['create','store']]); 
        $this->middleware(['permission:edit role'],['only' => ['edit','update']]); 
        $this->middleware(['permission:delete role'],['only' => ['destroy']]); 
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::select('id','name')->withCount('users')->paginate(10);
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = New Role();
        $permissions = [];
        return view('admin.roles.form',compact('role','permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|min:3',
            ]);
            $role = Role::create(['name' => $request->name]);
            $permissions = array_keys($request->permissions);
            $role->syncPermissions($permissions);
            return redirect()->route('admin.roles.index')->with(['success' => 'Role created succesfully']);
        } catch(e) {
            return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions;
        if(session()->getOldInput()){
            $permissions =  array_keys(session()->getOldInput()['permissions']);
        }
        else {
            $role->load('permissions:name');
            $permissions = $role->permissions->pluck('name')->toArray();
        }
        return view('admin.roles.form',compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required|min:3',
            ]);
            $role->update(['name' => $request->name ]);
            $permissions = array_keys($request->permissions);
            $role->syncPermissions($permissions);
            return redirect()->route('admin.roles.index')->with(['success' => 'Role updated succesfully']);
        } catch(e) {
            return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if($role && $role->delete()) {
            return redirect()->route('admin.roles.index')->with(['success' => 'Role deleted succesfully']);
          }
          return redirect()->back()->withErrors(['Error' => 'something went wrong!']);
    }

        /**
     * Remove the specified resource from storage.
     */
    public function roleUsers(Role $role)
    {
        $users =  User::with("roles")->whereHas("roles", function($q)  use ($role){
            $q->where("id", $role->id);
        })->paginate(10);
        return view('admin.users.index',compact('users'));
    }
}
