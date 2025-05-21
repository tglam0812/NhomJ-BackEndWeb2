<?php

namespace App\Http\Controllers;

use App\Models\PhieuGiamGia;
use Illuminate\Http\Request;

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
            'ten_phieu' => 'required',
            'phan_tram_giam' => 'required|numeric|min:1|max:100',
            'so_luong' => 'required|integer|min:1',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau', 
        ],[
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);


        PhieuGiamGia::create($request->all());

        return redirect()->route('phieugiam.index')->with('success', 'Thêm phiếu giảm thành công');
    }

    public function edit($id)
    {
        $pg = PhieuGiamGia::findOrFail($id);
        return view('crud_discount.edit', compact('pg'));
    }

    public function update(Request $request, $id)
    {
       $request->validate([
            'ten_phieu' => 'required',
            'phan_tram_giam' => 'required|numeric|min:1|max:100',
            'so_luong' => 'required|integer|min:1',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau', 
    ], [
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);


        $phieugiam = PhieuGiamGia::findOrFail($id);
        $phieugiam->update($request->all());

        return redirect()->route('phieugiam.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        PhieuGiamGia::destroy($id);
        return redirect()->back()->with('success', 'Xóa thành công');
    }
}
