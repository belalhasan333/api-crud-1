<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BlogStoreRequest;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();

        return response()->json([
            'blogs' => $blogs
        ], 200);
    }

    public function store(BlogStoreRequest $request)
    {
        try {
            // Generate clean image name
            $imageName = Str::slug(
                pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '-' . Str::random(10) . '.' . $request->image->getClientOriginalExtension();

            // Upload image
            Storage::disk('public')->put($imageName, file_get_contents($request->image));

            // Create Blog
            $blog = Blog::create([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'image' => $imageName,
                'price' => $request->price
            ]);

            return response()->json([
                'message' => "Blog created successfully",
                'image_url' => asset('storage/' . $imageName),
                'blog' => $blog
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went wrong",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'message' => 'Blog Not Found'
            ], 404);
        }

        return response()->json([
            'blog' => $blog
        ], 200);
    }

    public function update(BlogStoreRequest $request, $id)
    {
        try {
            $blog = Blog::find($id);

            if (!$blog) {
                return response()->json([
                    'message' => 'Blog Not Found'
                ], 404);
            }

            // Update text fields
            $blog->title = $request->title;
            $blog->subtitle = $request->subtitle;
            $blog->description = $request->description;
            $blog->price = $request->price;

            // If new image in request
            if ($request->hasFile('image')) {

                $storage = Storage::disk('public');

                // Delete old image
                if ($storage->exists($blog->image)) {
                    $storage->delete($blog->image);
                }

                // Generate new image name
                $imageName = Str::slug(
                    pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME)
                ) . '-' . Str::random(10) . '.' . $request->image->getClientOriginalExtension();

                // Upload new image
                $storage->put($imageName, file_get_contents($request->image));

                // Save new name in database
                $blog->image = $imageName;
            }

            $blog->save();

            return response()->json([
                'message' => "Blog updated successfully",
                'image_url' => asset('storage/' . $blog->image),
                'blog' => $blog
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went wrong",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);

        $blog->delete();

        return response()->json([
            'message' => "Blog deleted successfully"
        ], 200);

        if (!$blog) {
            return response()->json([
                'message' => 'Blog Not Found'
            ], 404);
        }

        $storage = Storage::disk('public');

        if ($storage->exists($blog->image)) {
            $storage->delete($blog->image);
        }


    }
}
