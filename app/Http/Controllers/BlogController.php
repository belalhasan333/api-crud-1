<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ImageUploadTrait;
use App\Http\Requests\BlogStoreRequest;

class BlogController extends Controller
{
    use ApiResponseTrait, ImageUploadTrait;

    /**
     * Display all blogs
     */
    public function index()
    {
        return $this->success("Blogs retrieved successfully", [
            'blogs' => Blog::all()
        ]);
    }

    /**
     * Store a new blog
     */
    public function store(BlogStoreRequest $request)
    {
        try {
            // Upload image
            $imageName = $this->uploadImage($request->image);

            // Create blog
            $blog = Blog::create([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->input('sub_category_id'),
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'image' => $imageName,
                'price' => $request->price,
            ]);

            return $this->success("Blog created successfully", $blog);
        } catch (\Exception $e) {
            return $this->error("Something went wrong", 500, $e->getMessage());
        }
    }

    /**
     * Show a single blog
     */
    public function show($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return $this->error("Blog not found", 404);
        }

        return $this->success("Blog retrieved successfully", [
            'blog' => $blog
        ]);
    }

    /**
     * Update blog
     */
    public function update(BlogStoreRequest $request, $id)
    {
        try {
            $blog = Blog::find($id);

            if (!$blog) {
                return $this->error("Blog not found", 404);
            }

            // Update base fields
            $blog->category_id = $request->category_id;
            $blog->sub_category_id= $request->input('sub_category_id');
            $blog->title = $request->title;
            $blog->subtitle = $request->subtitle;
            $blog->description = $request->description;
            $blog->price = $request->price;

            // Update image if new one uploaded
            if ($request->hasFile('image')) {
                $this->deleteImage($blog->image);

                $imageName = $this->uploadImage($request->image);
                $blog->image = $imageName;
            }

            $blog->save();

            return $this->success("Blog updated successfully", [
                'blog' => $blog
            ]);
        } catch (\Exception $e) {
            return $this->error("Something went wrong", 500, $e->getMessage());
        }
    }
    // Delete blog
    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return $this->error("Blog not found", 404);
        }

        // delete old image
        $this->deleteImage($blog->image);

        // delete blog
        $blog->delete();

        return $this->success("Blog deleted successfully");
    }
}
