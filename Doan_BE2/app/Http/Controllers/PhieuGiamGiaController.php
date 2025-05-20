<?php

namespace App\Http\Controllers;

use App\Models\PhieuGiamGia;
use Illuminate\Http\Request;

class PhieuGiamGiaController extends Controller
{
    public function index()
    {
        $ds = PhieuGiamGia::all();
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
            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',
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
       
    }

    public function destroy($id)
    {
        
    }
}
