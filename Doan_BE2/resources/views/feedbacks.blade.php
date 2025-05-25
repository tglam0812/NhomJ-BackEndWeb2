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

                <!-- Nút xóa -->
                <form action="{{ route('contact.delete', $item->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa phản hồi này?');" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-muted">Bạn chưa gửi câu hỏi nào.</p>
    @endforelse

    
		<div class="flex-c-m flex-w w-full p-t-45">
			{{ $messages->links() }}
		</div>
</div>
@endsection
