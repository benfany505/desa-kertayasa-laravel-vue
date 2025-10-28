<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Get latest news for homepage
     */
    public function latest(Request $request)
    {
        $limit = $request->get('limit', 6);

        $news = News::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'excerpt' => $item->excerpt,
                    'featured_image' => $item->featured_image,
                    'is_featured' => $item->is_featured,
                    'view_count' => $item->view_count,
                    'published_at' => $item->published_at,
                    'tags' => $item->tags
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    /**
     * Get all news with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);
        $search = $request->get('search');

        $query = News::where('status', 'published')
            ->orderBy('published_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $news->items(),
            'pagination' => [
                'current_page' => $news->currentPage(),
                'last_page' => $news->lastPage(),
                'per_page' => $news->perPage(),
                'total' => $news->total()
            ]
        ]);
    }

    /**
     * Get single news by slug
     */
    public function show($slug)
    {
        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }

        // Increment view count
        $news->increment('view_count');

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }
}
