<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $search_request = $request->search;
        $filter_request = $request->filter;
        $perPage = (int) $request->per_page;

        // $query = Blog::query()
        //     ->withCount('likes')
        //     ->with(['likes' => function ($qry) use ($userId) {
        //         $qry->where('user_id', $userId);
        //     }]);

        $query = Blog::withCount('likes')
            ->with(['likes' => fn($qry) => $qry->where('user_id', $userId)]);

        if (!empty($search_request)) {
            $query->where(function ($qry) use ($search_request) {
                $qry->where('title', 'LIKE', "%{$search_request}%")
                    ->orWhere('description', 'LIKE', "%{$search_request}%");
            });
        }

        if ($filter_request == 'most_liked') {
            $query->orderBy('likes_count', 'DESC');
        } elseif ($filter_request == 'latest') {
            $query->orderBy('id', 'DESC');
        } else {
            $query->orderBy('id', 'DESC');
        }

        if (!empty($perPage)) {
            $blogs = $query->paginate($perPage);
        } else {
            $blogs = $query->paginate(10);
        }

        // $blogs->getCollection()->transform(function ($blog) {
        //     $blog->is_liked = $blog->likes->isNotEmpty();
        //     unset($blog->likes);
        //     return $blog;
        // });

        return response()->json([
            'status' => true,
            'message' => 'Blog list.',
            'data' => $blogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'description' => 'required',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/blogs'), $imageName);
        }

        $blog = Blog::create([
            'user_id'     => $request->user()->id,
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imageName,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Blog created successfully',
            // 'data'    => $blog  // Data pass : as per requirments
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $blog_id)
    {
        $blog_details = Blog::find($blog_id);
        if (empty($blog_details)) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found'
            ]);
        }

        $request->validate([
            'title'       => 'required',
            'description' => 'required',
            'image'       => 'sometimes|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $blog_details->title = $request->title;
        $blog_details->description = $request->description;

        if ($request->hasFile('image')) {

            if ($blog_details->image && file_exists(public_path('uploads/blogs' . $blog_details->image))) {
                unlink(public_path('uploads/' . $blog_details->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/blogs'), $imageName);
            $blog_details->image = $imageName;
        }
        $blog_details->save();

        return response()->json([
            'status' => true,
            'message' => 'Blog details updated successfully',
            // 'data' => $blog_details
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($blog_id)
    {
        $blog_details = Blog::find($blog_id);
        if (empty($blog_details)) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found'
            ]);
        }

        if ($blog_details->image && file_exists(public_path('uploads/blogs' . $blog_details->image))) {
            unlink(public_path('uploads/blogs' . $blog_details->image));
        }

        $blog_details->delete();

        return response()->json([
            'status' => true,
            'message' => 'Blog deleted successfully'
        ]);
    }

    public function blog_like_toggle($id) // Like-Unlike
    {
        $blog = Blog::findOrFail($id);
        $user_id = auth()->id();

        $is_like = $blog->likes()->where('user_id', $user_id)->first();

        if (!empty($is_like)) { // Unlike

            $is_like->delete();
            return response()->json([
                'status' => true,
                'message' => 'Unliked successfully'
            ]);
        } else { // Like

            $blog->likes()->create([
                'user_id' => $user_id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Liked successfully'
            ]);
        }
    }
}
