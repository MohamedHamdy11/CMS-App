<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index')->with('users', User::all());
    } // end of index

    public function makeAdmin(User $user) 
    {
        $user->role = "admin";
        $user->save();
        return redirect(route('users.index'));
    } // end of makeAdmin

    public function makeWriter(User $user) 
    {
        $user->role = "writer";
        $user->save();
        return redirect(route('users.index'));
    } // end of makeWriter


} // end of UsersController
