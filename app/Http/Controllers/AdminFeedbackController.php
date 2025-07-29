<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::orderByDesc('created_at')->paginate(20);
        return view('admin.feedbacks', compact('feedbacks'));
    }

    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        if ($feedback->status === 'new') {
            $feedback->status = 'reviewed';
            $feedback->save();
        }
        return view('admin.feedback-show', compact('feedback'));
    }
}
