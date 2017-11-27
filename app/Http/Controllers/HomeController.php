<?php

namespace App\Http\Controllers;

use LaraFlash;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    LaraFlash::add()->content('Hello')->type('info');
    return view('home');
  }
}
