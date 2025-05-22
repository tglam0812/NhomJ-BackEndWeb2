<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class CrudSupplierController extends Controller
{
    /**
     * Hiển thị danh sách nhà cung cấp
     */
     public function listSupplier(Request $request)
    {
        $query = Supplier::query();
        $suppliers = $query->paginate(10);
        return view('crud_supplier.list', compact('suppliers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * xử lý form tạo nhà cung cấp
     */
    public function createSupplier(Request $request)
    {
        return view('crud_supplier.create');
    }

    /**
     * Xử lý form nhà cung cấp
     */
   public function postSupplier(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_email' =>  ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'], 
            'supplier_description' => 'nullable|string',
            'supplier_status' => 'required|boolean',
        ]);

        Supplier::create([
            'supplier_name' => $request->supplier_name,
            'supplier_email' => $request->supplier_email,
            'supplier_description' => $request->supplier_description,
            'supplier_status' => $request->supplier_status,
        ]);

        return redirect()->route('suppliers.list')->with('success', 'Nhà cung cấp đã được thêm thành công');
    }

     /**
     * Hiển thị form cập nhật nhà cung cấp
     */
    public function updateSupplier($supplier_id)
    {
        // $supplier = Supplier::findOrFail($supplier_id);
        // return view('crud_supplier.update', compact('supplier'));
        $supplier = Supplier::find($supplier_id);

    // Kiểm tra xem nhà cung cấp có tồn tại không
    if (!$supplier) {
        return redirect()->route('suppliers.list')->with('error', 'Nhà cung cấp không tồn tại');
    }

    return view('crud_supplier.update', compact('supplier'));
    }

     /**
     * Xử lý form cập nhật nhà cung cấp
     */
    public function postUpdateSupplier(Request $request, $supplier_id)
    {
       $request->validate([
        'supplier_name' => 'required|string|max:255',
        'supplier_email' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'], 
        'supplier_description' => 'nullable|string',
        'supplier_status' => 'required|boolean',
    ]);

    // Tìm nhà cung cấp
    $supplier = Supplier::find($supplier_id);

    // Kiểm tra xem nhà cung cấp có tồn tại không
    if (!$supplier) {
        return redirect()->route('suppliers.list')->with('error', 'Nhà cung cấp không tồn tại');
    }

    // Cập nhật nhà cung cấp
    $supplier->update([
        'supplier_name' => $request->supplier_name,
        'supplier_email' => $request->supplier_email,
        'supplier_description' => $request->supplier_description,
        'supplier_status' => $request->supplier_status,
    ]);

    return redirect()->route('suppliers.list')->with('success', 'Cập nhật nhà cung cấp thành công');
    }
    /**
     * Xem chi tiết nhà cung cấp
     */
    public function readSupplier($supplier_id)
    {
        $supplier = Supplier::with('supplier')->findOrFail($supplier_id);
        return view('crud_supplier.read', compact('supplier'));
    }

    /**
     * Xóa danh mục
     */
    public function deleteSupplier($supplier_id)
    {
        // //tim 
        // $supplier = Supplier::findOrFail($supplier_id);
        //  // Xóa danh mục
        // $supplier->delete();
        // return redirect()->route('suppliers.list')->with('success', 'Nhà cung cấp và các sản phẩm đã được xóa');
        $supplier = Supplier::find($supplier_id);

        // Kiểm tra xem nhà cung cấp có tồn tại không
        if (!$supplier) {
            return redirect()->route('suppliers.list')->with('error', 'Nhà cung cấp không tồn tại');
        }

        // Xóa nhà cung cấp
        $supplier->delete();
        return redirect()->route('suppliers.list')->with('success', 'Nhà cung cấp và các sản phẩm đã được xóa');
    }
}
