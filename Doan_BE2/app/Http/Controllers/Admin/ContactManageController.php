<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactManageController extends Controller
{
    public function index()
    {
        // Chỉ lấy các phản hồi CHƯA trả lời (reply = null)
        $messages = ContactMessage::with('user')
                    ->whereNull('reply')
                    ->latest()
                    ->get();

        return view('admin.messages', compact('messages'));
    }


    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|max:1000'
        ]);

        $message = ContactMessage::findOrFail($id);
        $message->reply = $request->reply;
        $message->save();

        return back()->with('success', 'Phản hồi đã được gửi thành công.');
    }
}

