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
}

