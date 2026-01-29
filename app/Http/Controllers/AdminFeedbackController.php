<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        $unreadFeedbacks = Feedback::where('status', 'unread')->latest()->get();
        $readFeedbacks = Feedback::where('status', 'read')->latest('read_at')->get();

        return view('admin.feedback.index', compact('unreadFeedbacks', 'readFeedbacks'));
    }

    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('admin.feedback.show', compact('feedback'));
    }

    public function markAsRead($id)
    {
        $feedback = Feedback::findOrFail($id);
        
        if ($feedback->status === 'unread') {
            $feedback->update([
                'status' => 'read',
                'read_at' => now(),
            ]);
        }

        return redirect()->route('admin.feedback.index')->with('success', 'Feedback marked as read.');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);

        if ($feedback->status === 'unread') {
            return back()->with('error', 'Cannot delete unread feedback.');
        }

        $feedback->delete();

        return back()->with('success', 'Feedback deleted successfully.');
    }
}
