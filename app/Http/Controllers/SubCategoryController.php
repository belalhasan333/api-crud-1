<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\SubCategoryStoreRequest;

class SubCategoryController extends Controller
{
    /**
     * Display all sub categories
     */
    public function index()
    {
        $subCategories = SubCategory::with('category')->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Sub categories retrieved successfully',
            'data' => $subCategories
        ], 200);
    }

    /**
     * Store a new sub category
     */
    public function store(SubCategoryStoreRequest $request)
    {
        $data = $request->validated();

        // Auto generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $subCategory = SubCategory::create($data);

        return response()->json([
            'status' => 201,
            'message' => 'Sub category created successfully',
            'data' => $subCategory
        ], 201);
    }

    /**
     * Show single sub category
     */
    public function show($id)
    {
        $subCategory = SubCategory::with('category')->find($id);

        if (!$subCategory) {
            return response()->json([
                'status' => 404,
                'message' => 'Sub category not found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $subCategory
        ], 200);
    }

    /**
     * Update sub category
     */
    public function update(SubCategoryStoreRequest $request, $id)
    {
        $subCategory = SubCategory::find($id);

        if (!$subCategory) {
            return response()->json([
                'status' => 404,
                'message' => 'Sub category not found'
            ], 404);
        }

        $data = $request->validated();

        // Update slug if name changed
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $subCategory->update($data);

        return response()->json([
            'status' => 200,
            'message' => 'Sub category updated successfully',
            'data' => $subCategory
        ], 200);
    }

    /**
     * Delete sub category
     */
    public function destroy($id)
    {
        $subCategory = SubCategory::find($id);

        if (!$subCategory) {
            return response()->json([
                'status' => 404,
                'message' => 'Sub category not found'
            ], 404);
        }

        $subCategory->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Sub category deleted successfully'
        ], 200);
    }
}
