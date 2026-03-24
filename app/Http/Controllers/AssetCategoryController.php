<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;
use App\Http\Requests\AssetCategoryRequest;

class AssetCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $categories = AssetCategory::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('asset-categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('asset-categories.create');
    }

    public function store(AssetCategoryRequest $request)
    {
        $category = AssetCategory::create($request->validated());
        $this->logAudit('create', $category, 'Created category: ' . $category->name);
        
        return redirect()->route('asset-categories.index')->with('success', 'Category created successfully.');
    }

    public function show(AssetCategory $assetCategory)
    {
        $assetCategory->load('hardwareAssets');
        return view('asset-categories.show', compact('assetCategory'));
    }

    public function edit(AssetCategory $assetCategory)
    {
        return view('asset-categories.edit', compact('assetCategory'));
    }

    public function update(AssetCategoryRequest $request, AssetCategory $assetCategory)
    {
        $assetCategory->update($request->validated());
        $this->logAudit('update', $assetCategory, 'Updated category: ' . $assetCategory->name);
        
        return redirect()->route('asset-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(AssetCategory $assetCategory)
    {
        $this->logAudit('delete', $assetCategory, 'Deleted category: ' . $assetCategory->name);
        $assetCategory->delete();
        
        return redirect()->route('asset-categories.index')->with('success', 'Category deleted successfully.');
    }
}
