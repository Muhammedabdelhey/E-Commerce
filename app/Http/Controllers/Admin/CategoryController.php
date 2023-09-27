<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryRepository->allCategories();
        return view('admin.categories.categories ', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.categories.addcategory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);
        $category = $this->categoryRepository->createCategory(['name' => $request->name]);
        if (!$category) {
            return redirect()->back()->with('error', 'An Error Occuer');
        }
        return redirect()->route('categories.index')->with('message', 'Category ' . $category->name . ' added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.editcategory', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $category = $this->categoryRepository->updateCategory($category, [
            'name' => $request->name,
        ]);
        return redirect()->route('categories.index')->with('message', 'Category Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->subcategories()->count() > 0) {
            return redirect()->back()->with('error', "this Category can't deleted ");
        }
        $this->categoryRepository->deleteCategory($category);
        return redirect()->route('categories.index')->with('message', 'Category Deleted ');
    }
}
