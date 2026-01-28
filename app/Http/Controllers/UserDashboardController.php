<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\ReviewLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Kuliner::query()->with(['categories', 'place', 'ratings']);

        if ($request->filled('search')) {
            $query->where('nama_kuliner', 'like', '%' . $request->search . '%')
                ->orWhere('asal_daerah', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('nama_kategori', $request->category);
            });
        }

        if ($request->filled('status')) {
            $status = strtolower($request->status);
            if ($status === 'halal') {
                $query->where('is_halal', true);
            } elseif ($status === 'non-halal' || $status === 'non_halal') {
                $query->where('is_halal', false);
            } elseif ($status === 'vegetarian') {
                $query->where('is_vegetarian', true);
            }
        }

        $kuliners = $query->latest()->get();
        $categories = Category::all();

        return view('dashboarduser', compact('kuliners', 'categories'));
    }

    public function favorites(Request $request)
    {
        $user = Auth::user();
        
        // Get kuliner that are favorited by this user
        $query = Kuliner::query()
            ->with(['categories', 'place', 'ratings'])
            ->whereHas('favorites', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

        if ($request->filled('search')) {
            $query->where('nama_kuliner', 'like', '%' . $request->search . '%')
                ->orWhere('asal_daerah', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('nama_kategori', $request->category);
            });
        }

        $kuliners = $query->latest()->get();
        $categories = Category::all();

        return view('favorites', compact('kuliners', 'categories'));
    }

    public function show($id)
    {
        try {
            $kuliner = Kuliner::with(['categories', 'place', 'reviews.user', 'reviews.likes', 'ratings'])->findOrFail($id);

            $user = Auth::user();
            $userRating = $kuliner->ratings()->where('user_id', $user->id)->first();
            $isFavorited = $kuliner->isFavoritedBy($user);

            // Transform reviews to include isLikedBy current user
            $reviews = $kuliner->reviews()->with('user')->latest()->get()->map(function ($review) use ($user) {
                return [
                    'id' => $review->id,
                    'ulasan' => $review->ulasan,
                    'created_at' => $review->created_at,
                    'user' => [
                        'id' => $review->user->id,
                        'name' => $review->user->name,
                    ],
                    'is_liked' => $review->isLikedBy($user),
                    'likes_count' => $review->likes()->count(),
                ];
            });

            return response()->json([
                'kuliner' => $kuliner,
                'user_rating' => $userRating ? $userRating->rating : 0,
                'is_favorited' => $isFavorited,
                'reviews' => $reviews,
                'average_rating' => $kuliner->average_rating
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to load kuliner data: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data: ' . $e->getMessage()], 500);
        }
    }

    public function toggleFavorite(Kuliner $kuliner)
    {
        $user = Auth::user();
        if ($kuliner->isFavoritedBy($user)) {
            $kuliner->favorites()->where('user_id', $user->id)->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'kuliner_id' => $kuliner->id
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function rate(Request $request, Kuliner $kuliner)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();

        $rating = Rating::updateOrCreate(
            ['user_id' => $user->id, 'kuliner_id' => $kuliner->id],
            ['rating' => $request->rating]
        );

        return response()->json(['status' => 'success', 'rating' => $rating->rating, 'average_rating' => $kuliner->average_rating]);
    }

    public function storeReview(Request $request, Kuliner $kuliner)
    {
        $request->validate([
            'ulasan' => 'required|string|max:1000',
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'kuliner_id' => $kuliner->id,
            'ulasan' => $request->ulasan,
        ]);

        $review->load('user');

        return response()->json(['status' => 'success', 'review' => $review]);
    }

    public function toggleReviewLike(Review $review)
    {
        $user = Auth::user();
        $like = ReviewLike::where('user_id', $user->id)->where('review_id', $review->id)->first();

        if ($like) {
            $like->delete();
            return response()->json(['status' => 'removed', 'likes_count' => $review->likes()->count()]);
        } else {
            ReviewLike::create([
                'user_id' => $user->id,
                'review_id' => $review->id
            ]);
            return response()->json(['status' => 'added', 'likes_count' => $review->likes()->count()]);
        }
    }
}
