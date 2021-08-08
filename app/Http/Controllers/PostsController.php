<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Post, Category, Tag};
// use App\Category;
// use App\Tag;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkCategory')->only('create');
    }

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
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
        // return view('posts.create')->with('categories', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //dd($request->all());
       //dd($request->image->store('images','public'));
        $post = Post::create([
           'title' => $request->title,
           'description' => $request->description,
           'content' => $request->content,
           'image' => $request->image->store('images','public'),
           'category_id' => $request->categoryID
       ]);

       if($request->tags)
       {
           $post->tags()->attach($request->tags); // store m -> n
       }

       session()->flash('success', 'post created successfully');
       return redirect(route('posts.index'));
    } // end of store

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
        return view('posts.create', ['post' => $post,
        'categories' => Category::all(),
         'tags' => Tag::all()]);
    } // end of edit

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
        if($request->hasFile('image')) {
            $image = $request->image->store('images', 'public');
            Storage::disk('public')->delete($post->image);
            $data['image'] = $image;
        }
    
        if($request->tags) {
            $post->tags()->sync($request->tags);
        }

        $post->update($data);

        session()->flash('success', 'post updated successfully');
        return redirect(route('posts.index'));
    } // end of update

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // dd(Post::withTrashed());
       //dd(Post::all());
       $post = Post::withTrashed()->where('id', $id)->first();

       if($post->trashed()) {
            //Storage::delete($post->image);  OR
            Storage::disk('public')->delete($post->image);
            $post->forceDelete();
       }
        else
            $post->delete();

        session()->flash('success', 'post trashed successfully');
        return redirect(route('posts.index'));
    } // end of destroy

    /**
     * get soft deletes posts
     *
     * @return void
     */
    public function trashed()
    {
        //Retrieve Posts (trashed)softDeletes
        $trashed = Post::onlyTrashed()->get();
       // return view('posts.index')->with('posts', $trashed);
       return view('posts.index')->withPosts($trashed);
    } // end of trashed


    public function restore($id)
    {
        Post::withTrashed()->where('id' , $id)->restore();
        session()->flash('success', 'post restored successfully');
        return redirect(route('posts.index'));
    } // end of restore

} // end of controller
