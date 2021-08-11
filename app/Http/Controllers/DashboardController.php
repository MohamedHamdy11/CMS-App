<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{User, Post, Category};

class DashboardController extends Controller
{
  public function index() {
    return view('dashboard.index',[
      'posts_count' => Post::all()->count(),
      'users_count' => User::all()->count(),
      'categories_count' => Category::all()->count()
    ]);
  } // end of index
  
} // end of DashboardController