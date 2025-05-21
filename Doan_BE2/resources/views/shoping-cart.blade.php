@extends('layouts.master')

@section('title')
Thương Mại Điện Tử
@endsection

@section('main-content')
<section class="bg0 p-t-75 p-b-85">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <thead>
                                <tr class="table_head">
                                    <th class="column-1">
                                        <input type="checkbox" id="checkAll" />
                                    </th>
                                    <th class="column-2">Product</th>
                                    <th class="column-3">Price</th>
                                    <th class="column-4">Quantity</th>
                                    <th class="column-5">Total</th>
                                    <th class="column-6">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(session()->has('cart') && count(session('cart')) > 0)
                                    @foreach(session('cart') as $item)
                                        @php $lineTotal = $item['product_price'] * $item['quantity']; @endphp
                                        <tr class="table_row">
                                            <td class="column-1">
                                                <input type="checkbox" class="product-checkbox" name="selected_products[]" value="{{ $item['product_id'] }}" />
                                            </td>
                                            <td class="column-2">
                                                <div class="how-itemcart1">
                                                    <img src="{{ asset('assets/images/products/' . $item['product_image']) }}" alt="IMG">
                                                </div>
                                                <br>
                                                {{ $item['product_name'] }}
                                            </td>
                                            <td class="column-3">{{ number_format($item['product_price']) }} VND</td>
                                            <td class="column-4">
                                                <form action="{{ route('cart.update', ['id' => $item['product_id']]) }}" method="POST" style="display: flex; align-items: center; gap: 5px;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width: 60px; text-align: center;" />
                                                    <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                                                </form>
                                            </td>
                                            <td class="column-5">{{ number_format($lineTotal) }} VND</td>
                                            <td class="column-6">
                                                <form action="{{ route('cart.remove', ['id' => $item['product_id']]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">X</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="6" class="text-center text-danger py-3"><i class="bi bi-cart-fill"></i> Giỏ hàng đang trống</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @php $coupon = session('coupon'); @endphp

            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-30 m-r-20 m-lr-0-xl p-lr-15-sm">
                <h4 class="mtext-109 cl2 p-b-30">Cart Totals</h4>

                <div class="flex-w flex-t bor12 p-b-13">
                    <div class="size-208"><span class="stext-110 cl2">Subtotal:</span></div>
                    <div class="size-209"><span id="subtotal" class="mtext-110 cl2">0 VND</span></div>
                </div>

                @if($coupon)
                <div class="flex-w flex-t bor12 p-t-13 p-b-13">
                    <div class="size-208">
                        <span class="stext-110 cl2">Giảm giá ({{ $coupon['ma_phieu'] }}):</span>
                    </div>
                    <div class="size-209">
                        <span id="discount" class="mtext-110 cl2 text-danger">0 VND</span>
                    </div>
                </div>
                @endif

                <div class="flex-w flex-t p-t-27 p-b-33">
                    <div class="size-208"><span class="mtext-101 cl2">Total:</span></div>
                    <div class="size-209 p-t-1"><span id="total" class="mtext-110 cl2">0 VND</span></div>
                </div>

                <div class="mb-3 d-flex gap-2 align-items-center">
                    @if(!session()->has('coupon'))
                        <form action="{{ route('cart.applyCoupon') }}" method="POST" class="d-flex gap-2 w-100">
                            @csrf
                            <input type="text" name="ma_phieu" class="form-control" placeholder="Nhập mã giảm giá" style="max-width: 200px;">
                            <button type="submit" class="btn btn-success">Áp dụng</button>
                        </form>
                    @else
                        <input type="text" class="form-control bg-light text-dark" value="{{ session('coupon')['ma_phieu'] }}" readonly style="max-width: 200px;">
                        <form action="{{ route('cart.removeCoupon') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">Hủy</button>
                        </form>
                    @endif
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <a href="{{ route('checkout.index') }}" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                    Thanh Toán
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const coupon = {!! json_encode(session('coupon')) !!};

    function formatVND(number) {
        return new Intl.NumberFormat('vi-VN').format(number) + ' VND';
    }

    function updateCartSummary() {
        let subtotal = 0;
        const checkedIds = [];

        document.querySelectorAll('.product-checkbox').forEach(chk => {
            if (chk.checked) {
                checkedIds.push(chk.value);
                let row = chk.closest('tr');
                let price = parseFloat(row.querySelector('.column-3').innerText.replace(/[^\d]/g, ''));
                let quantity = parseInt(row.querySelector('input[name="quantity"]').value);
                subtotal += price * quantity;
            }
        });

        localStorage.setItem('checkedProducts', JSON.stringify(checkedIds));

        let discount = 0;
        if (coupon && subtotal > 0) {
            if (coupon.loai_giam === 'percent') {
                discount = subtotal * coupon.gia_tri / 100;
            } else {
                discount = coupon.gia_tri;
            }
            if (discount > subtotal) discount = subtotal;
        }

        let total = subtotal - discount;
        if (total < 0) total = 0;

        document.getElementById('subtotal').innerText = formatVND(subtotal);
        if (document.getElementById('discount')) {
            document.getElementById('discount').innerText = '-' + formatVND(discount);
        }
        document.getElementById('total').innerText = formatVND(total);
    }

    // Load trạng thái checkbox đã lưu trước đó
    const prevChecked = JSON.parse(localStorage.getItem('checkedProducts') || '[]');
    document.querySelectorAll('.product-checkbox').forEach(chk => {
        if (prevChecked.includes(chk.value)) {
            chk.checked = true;
        }
    });

    // Bắt sự kiện checkbox và quantity thay đổi
    document.querySelectorAll('.product-checkbox, input[name="quantity"]').forEach(e => {
        e.addEventListener('change', updateCartSummary);
    });

    // Check all
    document.getElementById('checkAll').addEventListener('change', function () {
        const checked = this.checked;
        document.querySelectorAll('.product-checkbox').forEach(chk => {
            chk.checked = checked;
        });
        updateCartSummary();
    });

    // Gọi khi trang load
    updateCartSummary();
});
</script>

</script>
@endsection

