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
        //search
        if ($search = $request->input('search')) {
            $query->where('supplier_name', 'like', "%$search%");
        }
        $suppliers = $query->paginate(5)->appends($request->only('search'));
        return view('crud_supplier.list', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crud_supplier.create');
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
            'supplier_email' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
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
        // Validate dữ liệu cơ bản
        $request->validate([
            'supplier_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s]+$/' // Cho phép chữ cái, số và khoảng trắng
            ],
            'supplier_email' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            'supplier_description' => 'nullable|string',
            'supplier_status' => 'required|boolean',
            'updated_at' => 'required' // Nhận updated_at từ form
        ], [
            'supplier_name.regex' => 'Tên nhà cung cấp chỉ được chứa chữ cái, số và khoảng trắng, không chứa ký tự đặc biệt.'
        ]);

        // Tìm nhà cung cấp
        $supplier = Supplier::find($supplier_id);

        // Kiểm tra xem nhà cung cấp có tồn tại không
        if (!$supplier) {
            return redirect()->route('suppliers.list')->with('error', 'Nhà cung cấp không tồn tại');
        }

        // Kiểm tra tính duy nhất của email (ngoại trừ bản ghi hiện tại)
        $existingSupplier = Supplier::where('supplier_email', $request->supplier_email)
            ->where('supplier_id', '!=', $supplier_id)
            ->first();

        if ($existingSupplier) {
            return back()->withInput()->with('error', 'Email này đã được sử dụng bởi một nhà cung cấp khác.');
        }

        // Kiểm tra concurrency
        if ($supplier->updated_at->toDateTimeString() !== $request->updated_at) {
            return back()->withInput()->with('error', 'Nhà cung cấp đã bị thay đổi bởi người khác. Vui lòng tải lại trang.');
        }

        // Cập nhật nhà cung cấp với supplier_name đã được trim
        $supplier->update([
            'supplier_name' => trim($request->supplier_name), // Loại bỏ khoảng trắng đầu và cuối
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
        $supplier = Supplier::findOrFail($supplier_id);
        return view('crud_supplier.read', compact('supplier'));
    }

    /**
     * Xóa nhà cung cấp
     */
    public function deleteSupplier($supplier_id)
    {
        $supplier = Supplier::find($supplier_id);

        // Kiểm tra xem nhà cung cấp có tồn tại không
        if (!$supplier) {
            return redirect()->route('suppliers.list')->with('error', 'Nhà cung cấp không tồn tại');
        }

        // Xóa nhà cung cấp
        $supplier->delete();
        return redirect()->route('suppliers.list')->with('success', 'Nhà cung cấp đã được xóa');
    }
}