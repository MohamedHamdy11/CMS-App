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

    public function edit(User $user) 
    {
        $profile = $user->profile;
        return view('users.profile', ['user' => $user, 'profile' => $profile]);
    } // end of edit

    public function update(User $user, Request $request)
    {
        // dd($request->all());
        $profile = $user->profile;
        $data = $request->all();
        if ($request->hasFile('picture')) {
          $picture = $request->picture->store('profilesPicture', 'public');
          $data['picture'] = $picture;
        }
        $profile->update($data);
        return redirect(route('home'));
    } // end of update


} // end of UsersController
