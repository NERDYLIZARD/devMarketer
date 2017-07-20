<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $permissions = Permission::all();
      return view('manage.permissions.index', ['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('manage.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // basic permission
      if ($request->permission_type == 'basic') {
        $this->validate($request, [
          'display_name' => 'required|max:255',
          'name' => 'required|max:255|alpha_dash|unique:permissions,name',
          'description' => 'sometimes|max:255',
        ]);
        $permission = new Permission([
          'name' => $request->name,
          'display_name' => $request->display_name,
          'description' => $request->description,
        ]);
        if (!$permission->save()) {
          Session::flash('error', 'Sorry a problem occurred while creating this permission. Try again later.');
          return redirect()->back();
        }
        Session::flash('success', 'Permission has been successfully added');
        return redirect()->route('permissions.show', $permission->id);
      }

      // crud permission
      if ($request->permission_type == 'crud') {
        $this->validate($request, [
          'resource' => 'required|min:3|max:100|alpha',
          // if no crud selected => crud_selected is null, therefore, invalid
          'crud_selected' => 'required',
        ]);

        // build array from string "crud_selected"
        $crud = explode(',', $request->crud_selected);
        foreach ($crud as $x) {
          $slug = strtolower($x) . '-' . strtolower($request->resource);
          $display_name = ucwords($x . " " . $request->resource);
          $description = "Allows a user to " . strtoupper($x) . ' ' . ucwords($request->resource);

          $permission = new Permission([
            'name' => $slug,
            'display_name' => $display_name,
            'description' => $description,
          ]);
          if (!$permission->save()) {
            Session::flash('error', 'Sorry a problem occurred while creating this permission. Try again later.');
            return redirect()->back();
          }
        }
        Session::flash('success', 'All permissions have been successfully added');
        return redirect()->route('permissions.index');
      }

      // no selected => something is wrong
      return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $permission = Permission::findOrFail($id);
      return view('manage.permissions.show', ['permission' => $permission]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $permission = Permission::findOrFail($id);
      return view('manage.permissions.edit', ['permission' => $permission]);
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
      ]);
      $permission = Permission::findOrFail($id);
      $permission->display_name = $request->display_name;
      $permission->description = $request->description;

      if (!$permission->save()) {
        Session::flash('error', 'Sorry a problem occurred while updating this permission. Try again later.');
        return redirect()->back();
      }
      Session::flash('success', 'Permission '. $permission->display_name . ' has been successfully updated');
      return redirect()->route('permissions.show', $id);
    }

}
