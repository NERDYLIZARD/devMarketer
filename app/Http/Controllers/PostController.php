<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{

  public function __construct()
  {
    $this->middleware('role:superadministrator|administrator|editor|author|contributor');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('manage.posts.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('manage.posts.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }


  // check slug uniqueness
  public function apiGetUniqueSlug(Request $request)
  {
    return json_encode($this->getUniqueSlug($request->slug));
  }

  // Sample input: slug
  // Sample output: slug, slug-1, slug-2, ...
  private function getUniqueSlug($input, $counter = 0)
  {
    $slug = $input . ($counter > 0 ? "-$counter" : '');

    $isUniqueSlug = !Post::where('slug', '=', $slug)->exists();

    if ($isUniqueSlug)
      return $slug;

    return $this->getUniqueSlug($input, $counter + 1);

  }

}
