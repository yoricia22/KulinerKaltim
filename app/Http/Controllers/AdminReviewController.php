<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'kuliner.ratings'])->latest()->get();
        return view('manageulasan', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Mark as hidden (Deleted status)
        $review->is_hidden = true;
        $review->save();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
