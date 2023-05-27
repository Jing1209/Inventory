<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
// use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //
        $categories = Category::where([
            ['category', '!=', Null],
            [function ($query) use ($request) {
                if ($term = $request->term) {
                    $query->orWhere('category', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])->orderBy('id', 'asc')->paginate(10);
        return view('Category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'category' => 'required|unique:categories',
            // 'quantity' => 'required',

        ]);

        Category::create($request->post());

        return redirect()->route('categories.index')->with('success', 'Category has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        return view('Category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $request->validate([
            'category' => 'required|unique:categories'
        ]);
        $category->fill($request->post())->save();

        return redirect()->route('categories.index')->with('success', 'Category Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category Has Been removed successfully');
    }
}
