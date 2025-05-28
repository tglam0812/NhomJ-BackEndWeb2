<?php

namespace App\Http\Controllers;

use App\Models\PhieuGiamGia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PhieuGiamGiaController extends Controller
{
    public function index(Request $request)
    {
        $query = PhieuGiamGia::query();

        if ($request->has('search')) {
            $query->where('ten_phieu', 'like', '%' . $request->search . '%');
        }

        $ds = $query->paginate(5)->appends($request->only('search'));

        return view('crud_discount.index', compact('ds'));
    }

    public function create()
    {
        return view('crud_discount.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_phieu' => [
                'required',
                'max:100',
                'unique:phieu_giam_gia,ten_phieu',
                'regex:/^[a-zA-Z0-9À-ỹ\s%\-\/]+$/u'
            ],
            'phan_tram_giam' => 'required|numeric|min:1|max:100',
            'so_luong'        => 'required|integer|min:1',
            'ngay_bat_dau'    => 'required|date',
            'ngay_ket_thuc'   => 'required|date|after:ngay_bat_dau',
        ], [
            'ten_phieu.required' => 'Tên phiếu không được bỏ trống.',
            'ten_phieu.unique'   => 'Tên phiếu đã tồn tại.',
            'ten_phieu.regex'    => 'Tên phiếu chỉ chứa chữ, số, %, -, / và khoảng trắng.',
            'phan_tram_giam.required' => 'Vui lòng nhập phần trăm giảm.',
            'phan_tram_giam.max'      => 'Giảm giá tối đa 100%.',
            'so_luong.required'       => 'Vui lòng nhập số lượng phiếu.',
            'ngay_ket_thuc.after'     => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        PhieuGiamGia::create($request->only([
            'ten_phieu', 'phan_tram_giam', 'so_luong', 'ngay_bat_dau', 'ngay_ket_thuc', 'mo_ta'
        ]));

        return redirect()->route('phieugiam.index')->with('success', 'Thêm phiếu giảm giá thành công!');
    }

    public function edit($id)
    {
        $pg = PhieuGiamGia::find($id);

        if (!$pg) {
            return redirect()->route('phieugiam.index')->with('error', 'Phiếu giảm giá không tồn tại hoặc đã bị xóa.');
        }

        return view('crud_discount.edit', compact('pg'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ten_phieu' => [
                'required',
                'max:100',
                Rule::unique('phieu_giam_gia', 'ten_phieu')->ignore($id),
                'regex:/^[a-zA-Z0-9À-ỹ\s%\-\/]+$/u'
            ],
            'phan_tram_giam' => 'required|numeric|min:1|max:100',
            'so_luong'        => 'required|integer|min:1',
            'ngay_bat_dau'    => 'required|date',
            'ngay_ket_thuc'   => 'required|date|after:ngay_bat_dau',
        ], [
            'ten_phieu.required' => 'Tên phiếu không được bỏ trống.',
            'ten_phieu.unique'   => 'Tên phiếu đã tồn tại.',
            'ten_phieu.regex'    => 'Tên phiếu chỉ chứa chữ, số, %, -, / và khoảng trắng.',
            'phan_tram_giam.required' => 'Vui lòng nhập phần trăm giảm.',
            'phan_tram_giam.max'      => 'Giảm giá tối đa 100%.',
            'so_luong.required'       => 'Vui lòng nhập số lượng phiếu.',
            'ngay_ket_thuc.after'     => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        $pg = PhieuGiamGia::find($id);

        if (!$pg) {
            return redirect()->route('phieugiam.index')->with('error', 'Phiếu giảm giá không tồn tại hoặc đã bị xóa.');
        }

        $pg->update($request->only([
            'ten_phieu', 'phan_tram_giam', 'so_luong', 'ngay_bat_dau', 'ngay_ket_thuc', 'mo_ta'
        ]));

        return redirect()->route('phieugiam.index')->with('success', 'Cập nhật phiếu giảm giá thành công!');
    }

    public function destroy($id)
    {
        $coupon = PhieuGiamGia::find($id);
        if (!$coupon) {
            return redirect()->back()->with('error', 'Phiếu giảm giá không tồn tại hoặc đã bị xoá.');
        }

        $coupon->delete();

        return redirect()->back()->with('success', 'Đã xoá thành công phiếu giảm giá!');
    }
}
