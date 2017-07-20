<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $roles = Role::all();
      return view('manage.roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $permissions = Permission::all();
      return view('manage.roles.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'display_name' => 'required|max:255',
        'name' => 'required|max:100|alpha_dash|unique:roles,name',
        'description' => 'sometimes|max:255',
        'permissions' => 'required',
      ]);
      $role = new Role([
        'name' => $request->name,
        'display_name' => $request->display_name,
        'description' => $request->description,
      ]);
      if (!$role->save()) {
        Session::flash('error', 'Sorry a problem occurred while creating this role. Try again later.');
        return redirect()->back();
      }
      $role->syncPermissions(explode(',', $request->permissions));
      Session::flash('success', 'Role has been successfully added');
      return redirect()->route('roles.show', $role->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $role = Role::where('id', $id)->with('permissions')->first();
      return view('manage.roles.show', ['role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $role = Role::where('id', $id)->with('permissions')->first();
      $permissions = Permission::all();
      return view('manage.roles.edit', ['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, [
        'display_name' => 'required|max:255',
        'description' => 'sometimes|max:255',
        'permissions' => 'required',
      ]);
      $role = Role::findOrFail($id);
      $role->display_name = $request->display_name;
      $role->description = $request->description;
      if (!$role->save()) {
        Session::flash('error', 'Sorry a problem occurred while updating this role. Try again later.');
        return redirect()->back();
      }
      $role->syncPermissions(explode(',', $request->permissions));
      Session::flash('success', 'Role '. $role->display_name . ' has been successfully updated');
      return redirect()->route('roles.show', $id);
    }

}
