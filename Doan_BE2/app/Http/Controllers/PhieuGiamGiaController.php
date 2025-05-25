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
                'unique:phieu_giam_gia,ten_phieu', // sửa lại tên bảng
                'regex:/^[a-zA-Z0-9À-ỹ\s%\-\/]+$/u'
            ],
            'phan_tram_giam' => 'required|numeric|min:1|max:100',
            'so_luong' => 'required|integer|min:1',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
        ], [
            'ten_phieu.required' => 'Tên phiếu không được bỏ trống.',
            'ten_phieu.unique' => 'Tên phiếu đã tồn tại.',
            'ten_phieu.regex' => 'Tên phiếu chỉ chứa chữ, số, %, -, / và khoảng trắng.',
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        PhieuGiamGia::create($request->all());

        return redirect()->route('phieugiam.index')->with('success', 'Thêm phiếu giảm thành công');
    }

    public function edit($id)
    {
        $pg = PhieuGiamGia::find($id);

        if (!$pg) {
            return redirect()->route('phieugiam.index')
                ->with('error', 'Phiếu giảm giá không tồn tại hoặc đã bị xóa. Vui lòng tải lại trang.');
        }

        return view('crud_discount.edit', compact('pg'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ten_phieu' => [
                'required',
                'max:100',
                Rule::unique('phieu_giam_gia', 'ten_phieu')->ignore($id), // sửa lại tên bảng
                'regex:/^[a-zA-Z0-9À-ỹ\s%\-\/]+$/u'
            ],
            'phan_tram_giam' => 'required|numeric|min:1|max:100',
            'so_luong' => 'required|integer|min:1',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
        ], [
            'ten_phieu.required' => 'Tên phiếu không được bỏ trống.',
            'ten_phieu.unique' => 'Tên phiếu đã tồn tại.',
            'ten_phieu.regex' => 'Tên phiếu chỉ chứa chữ, số, %, -, / và khoảng trắng.',
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        $phieugiam = PhieuGiamGia::find($id);

        if (!$phieugiam) {
            return redirect()->route('phieugiam.index')
                ->with('error', 'Phiếu giảm giá không tồn tại hoặc đã bị xóa. Vui lòng tải lại trang.');
        }

        $phieugiam->update([
            'ten_phieu'       => $request->ten_phieu,
            'phan_tram_giam'  => $request->phan_tram_giam,
            'so_luong'        => $request->so_luong,
            'ngay_bat_dau'    => $request->ngay_bat_dau,
            'ngay_ket_thuc'   => $request->ngay_ket_thuc,
            'mo_ta'           => $request->mo_ta,
        ]);

        return redirect()->route('phieugiam.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        PhieuGiamGia::destroy($id);
        return redirect()->back()->with('success', 'Xóa thành công');
    }
}
