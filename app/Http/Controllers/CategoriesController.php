<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategroyRequest;

use App\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index')->with('categories', Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategroyRequest $request)
    {

        // $request->validate([
        //     "name" => "required|unique:categories"
        // ]);

        //R1
        //$nCategory = new Category();
        // $nCategory->name = $request->name;

        /*  //R2
        Category::create([
            "name" => $request->name
        ]);
        */
        //R3  git in form (Add a new Category)
        //Error Mass AssignmentException (protected $fillable = ['name'])
        Category::create($request->all());

        session()->flash('success', 'category created successfuly');

        return redirect(route('categories.index'));
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
    public function edit(Category $category)
    {
        return view('categories.create')->with('category',$category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // R1
        //$category->name = $request->name;
        //$category->save();

        //R2
        $category->update([
            'name' => $request->name
        ]);

        session()->flash('success', 'category updated successfuly');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', 'category deleted successfuly');
        return redirect(route('categories.index'));
    }
}
