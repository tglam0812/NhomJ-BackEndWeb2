<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'msg' => 'required|string|max:1000'
        ]);


        ContactMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->msg
        ]);

        return back()->with('success', 'Cảm ơn bạn đã gửi liên hệ!');
    }

    public function feedbacks()
    {
        $messages = \App\Models\ContactMessage::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('feedbacks', compact('messages'));
    }
}

