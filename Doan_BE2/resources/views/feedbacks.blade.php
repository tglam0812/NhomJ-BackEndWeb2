@extends('layouts.master')
@section('title', 'Phản hồi của bạn')

@section('main-content')
<div class="container py-5 mt-5">
    <h3 class="mb-4">Phản hồi của bạn</h3>

    @forelse ($messages as $item)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <p><strong>Câu hỏi:</strong></p>
                <p>{{ $item->message }}</p>

                <hr>
                <p><strong>Phản hồi từ tư vấn:</strong></p>
                @if ($item->reply)
                    <div class="alert alert-success">{{ $item->reply }}</div>
                @else
                    <div class="text-muted fst-italic">Đang xử lý...</div>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">Bạn chưa gửi câu hỏi nào.</p>
    @endforelse
</div>
@endsection
