<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Repositories\CategoryRepository;
use App\Repositories\SubCategoryRepository;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function __construct(
        private SubCategoryRepository $subCategoryRepository,
        private CategoryRepository $categoryRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = $this->subCategoryRepository->allSubCategories();
        return view('admin.subcategory.subcategories', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryRepository->allCategories();
        return view('admin.subcategory.addsubcategory', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);
        $subcategory = $this->subCategoryRepository->createSubCategory([
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);
        if (!$subcategory) {
            return redirect()->back()->with('error', 'An Error Occuer');
        }
        return redirect()->back()->with('message', 'SubCategory ' . $subcategory->name . ' added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subcategory)
    {
        $categories = $this->categoryRepository->allCategories();
        return view('admin.subcategory.editsubcategory', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);
        $subcategory = $this->subCategoryRepository->updateSubCategory(
            $subcategory,
            [
                'name' => $request->name,
                'category_id' => $request->category_id
            ]
        );
        return redirect()->route('subcategory.index')->with('message', 'SubCategory Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subcategory)
    {
        // dd($subcategory);
        if ($subcategory->products->count() > 0) {
            return redirect()->back()->with('error', "this subcategory can't deleted ");
        }
        $subcategory = $this->subCategoryRepository->deleteSubCategory($subcategory);

        return redirect()->route('subcategory.index')->with('message', 'subCategory Deleted ');
    }
}
