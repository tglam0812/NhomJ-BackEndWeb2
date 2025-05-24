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
            ->paginate(2);

        return view('feedbacks', compact('messages'));
    }


    public function destroy($id)
    {
        $message = ContactMessage::find($id);

        if (!$message || $message->user_id !== Auth::id()) {
            return back()->with('error', 'Không tìm thấy phản hồi hoặc bạn không có quyền xóa.');
        }

        $message->delete();

        return back()->with('success', 'Phản hồi đã được xóa.');
    }

}

