<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboardadmin');
    }

    public function manageUsers()
    {
        $users = User::where('role', 'user')->get();
        return view('manageuser', compact('users'));
    }

    public function toggleBan(User $user)
    {
        if ($user->status === 'banned') {
            $user->status = 'active';
        } else {
            $user->status = 'banned';
        }
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');
    }
}
