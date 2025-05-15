@extends('dashboard')

@section('title', 'Quản lý phản hồi khách hàng')

@section('content')
<main class="feedback-list">
    <div class="container">
        <h3 class="mb-4">Danh sách phản hồi từ khách hàng</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @forelse ($messages as $item)
            <div class="card mb-4 shadow-sm feedback-card">
                <div class="card-body">
                    <p><strong>Khách hàng:</strong> {{ $item->user->full_name ?? 'N/A' }}</p>
                    <p><strong>Câu hỏi:</strong></p>
                    <div class="question-box">{{ $item->message }}</div>

                    <form method="POST" action="{{ route('admin.messages.reply', $item->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="reply" class="form-label">Phản hồi tư vấn:</label>
                            <textarea name="reply" class="form-control" rows="3" required>{{ $item->reply }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-muted">Hiện chưa có phản hồi nào từ khách hàng.</p>
        @endforelse
    </div>
</main>
@endsection

<style>
    .feedback-list {
        background-color: #f8f9fa;
        padding: 30px 0;
    }

    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 15px;
    }

    h3 {
        font-size: 24px;
        font-weight: bold;
        color: #343a40;
    }

    .feedback-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #e0e0e0;
    }

    .question-box {
        padding: 10px 15px;
        background-color: #f1f1f1;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    textarea.form-control {
        border-radius: 6px;
        resize: vertical;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        transition: 0.2s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        padding: 10px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }
</style>

