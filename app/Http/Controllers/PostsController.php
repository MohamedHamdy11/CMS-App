<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

       //dd($request->image->store('images','public'));
        Post::create([
           'title' => $request->title,
           'description' => $request->description,
           'content' => $request->content,
           'image' => $request->image->store('images','public')
       ]);

       /*
       $newPost = new Post();
       $newPost->title = $request->title;
       $newPost->description = $request->description;
       $newPost->content =  $request->content;
       $newPost->image = $request->image->store('images','public');
       */

       session()->flash('success', 'post created successfully');

       return redirect(route('posts.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title', 'description','content']);
        //check for update images
        if($request->hasFile('image'))
        {
            $image = $request->image->store('images', 'public');
            Storage::disk('public')->delete($post->image);
            $data['image'] = $image;
        }

        $post->update($data);

        session()->flash('success', 'post updated successfully');
        return redirect(route('posts.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // $post->delete();
       // session()->flash('success', 'post trashed successfully');
       // return redirect(route('posts.index'));

       // dd(Post::withTrashed());
       //dd(Post::all());

       $post = Post::withTrashed()->where('id', $id)->first();

       if($post->trashed())
       {
        //Storage::delete($post->image);  OR
        Storage::disk('public')->delete($post->image);
        $post->forceDelete();
       }
        else
            $post->delete();

        session()->flash('success', 'post trashed successfully');
        return redirect(route('posts.index'));

    }

    /**
     * soft deletes posts
     *
     * @return void
     */
    public function trashed()
    {
        //Retrieve Posts (trashed)softDeletes
        $trashed = Post::onlyTrashed()->get();
       // return view('posts.index')->with('posts', $trashed);
       return view('posts.index')->withPosts($trashed);

    }


    public function restore($id)
    {
        Post::withTrashed()->where('id' , $id)->restore();
        session()->flash('success', 'post restored successfully');
        return redirect(route('posts.index'));

    }

}
