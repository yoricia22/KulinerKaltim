<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kuliner;

class AdminController extends Controller
{
     public function dashboard()
    {
        $totalKuliner = Kuliner::count();
        $totalUsers = User::where('role', 'user')->count();
        // $totalReviews = Review::count(); // Uncomment jika sudah ada
        // $avgRating = Review::avg('rating'); // Uncomment jika sudah ada
        $totalReviews = 0; // Sementara
        $avgRating = 0; // Sementara

        $recentKuliner = Kuliner::latest()->take(5)->get();
        $recentUsers = User::where('role', 'user')->latest()->take(5)->get();

        return view('dashboardadmin', compact(
            'totalKuliner',
            'totalUsers',
            'totalReviews',
            'avgRating',
            'recentKuliner',
            'recentUsers'
        ));
    }

    public function manageUsers()
    {
        $users = User::where('role', 'user')->get();
        return view('manageuser', compact('users'));
    }

    public function toggleBan(User $user)
    {
        $user->is_banned = !$user->is_banned;
        $user->save();

        $status = $user->is_banned ? 'banned' : 'unbanned';
        return redirect()->back()->with('success', "User has been {$status} successfully.");
    }
}
