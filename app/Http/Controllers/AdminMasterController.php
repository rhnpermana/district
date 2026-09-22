<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\WorkShift;
use App\Models\Complaint;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMasterController extends Controller
{
    /**
     * Store new Service
     */
    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:15',
            'description' => 'nullable|string',
        ]);

        $service = Service::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'description' => $request->description,
            'is_active' => true,
        ]);

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Create Service',
            'details' => "Admin membuat layanan baru: {$service->name} (Rp " . number_format($service->price, 0, ',', '.') . ")",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Layanan baru '{$service->name}' berhasil ditambahkan!");
    }

    /**
     * Update existing Service
     */
    public function updateService(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:15',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $service->update([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : $service->is_active,
        ]);

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Service',
            'details' => "Admin memperbarui data layanan: {$service->name} (#{$service->id})",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Layanan '{$service->name}' berhasil diperbarui!");
    }

    /**
     * Toggle active status of Service
     */
    public function toggleService(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);
        $statusText = $service->is_active ? 'Diaktifkan' : 'Dinonaktifkan';

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Toggle Service Status',
            'details' => "Admin merubah status layanan {$service->name} menjadi {$statusText}",
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', "Status layanan '{$service->name}' berhasil {$statusText}!");
    }

    /**
     * Delete Service
     */
    public function deleteService(Service $service)
    {
        $serviceName = $service->name;
        $service->delete();

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete Service',
            'details' => "Admin menghapus layanan: {$serviceName}",
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', "Layanan '{$serviceName}' telah dihapus.");
    }

    /**
     * Store new Product
     */
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product = Product::create($request->only([
            'name', 'category', 'price', 'stock', 'min_stock', 'description',
        ]));

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Create Product',
            'details' => "Admin menambah produk katalog baru: {$product->name} (Rp " . number_format($product->price, 0, ',', '.') . ")",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Produk baru '{$product->name}' berhasil ditambahkan!");
    }

    /**
     * Update existing Product
     */
    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product->update($request->all());

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Product',
            'details' => "Admin memperbarui data produk: {$product->name} (#{$product->id})",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Produk '{$product->name}' berhasil diperbarui!");
    }

    /**
     * Quick Update / Restock Product Stock
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'add_stock' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        $oldStock = $product->stock;
        $newStock = $request->filled('add_stock') ? ($oldStock + $request->add_stock) : ($request->stock ?? $oldStock);
        $minStock = $request->min_stock ?? $product->min_stock;

        $product->update([
            'stock' => $newStock,
            'min_stock' => $minStock,
        ]);

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Restock Product',
            'details' => "Admin mengupdate stok produk '{$product->name}' dari {$oldStock} pcs menjadi {$newStock} pcs",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Stok produk '{$product->name}' berhasil diperbarui menjadi {$newStock} pcs!");
    }

    /**
     * Delete Product
     */
    public function deleteProduct(Product $product)
    {
        $productName = $product->name;
        $product->delete();

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete Product',
            'details' => "Admin menghapus produk: {$productName}",
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', "Produk '{$productName}' telah dihapus.");
    }

    /**
     * Store new Voucher Promo
     */
    public function storeVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:vouchers,code|max:50',
            'type' => 'required|string|in:percent,fixed',
            'discount_value' => 'required|numeric|min:1',
            'min_spend' => 'required|numeric|min:0',
            'valid_until' => 'nullable|date',
        ]);

        $voucher = Voucher::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'discount_value' => $request->discount_value,
            'min_spend' => $request->min_spend,
            'valid_until' => $request->valid_until,
            'is_active' => true,
        ]);

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Create Voucher',
            'details' => "Admin membuat voucher promo baru: {$voucher->code}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Voucher promo '{$voucher->code}' berhasil diterbitkan!");
    }

    /**
     * Update Voucher
     */
    public function updateVoucher(Request $request, Voucher $voucher)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'type' => 'required|string|in:percent,fixed',
            'discount_value' => 'required|numeric|min:1',
            'min_spend' => 'required|numeric|min:0',
            'valid_until' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $voucher->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'discount_value' => $request->discount_value,
            'min_spend' => $request->min_spend,
            'valid_until' => $request->valid_until,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : $voucher->is_active,
        ]);

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Voucher',
            'details' => "Admin memperbarui voucher promo: {$voucher->code}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Voucher promo '{$voucher->code}' berhasil diperbarui!");
    }

    /**
     * Toggle active status of Voucher
     */
    public function toggleVoucher(Voucher $voucher)
    {
        $voucher->update(['is_active' => !$voucher->is_active]);
        $statusText = $voucher->is_active ? 'Diaktifkan' : 'Dinonaktifkan';

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Toggle Voucher Status',
            'details' => "Admin merubah status voucher {$voucher->code} menjadi {$statusText}",
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', "Voucher '{$voucher->code}' berhasil {$statusText}!");
    }

    /**
     * Delete Voucher
     */
    public function deleteVoucher(Voucher $voucher)
    {
        $code = $voucher->code;
        $voucher->delete();

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete Voucher',
            'details' => "Admin menghapus voucher: {$code}",
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', "Voucher promo '{$code}' telah dihapus.");
    }

    /**
     * Admin Store Shift
     */
    public function storeShift(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shift_date' => 'required|date',
            'shift_type' => 'required|string|in:Pagi,Siang,Full,Off',
            'notes' => 'nullable|string',
        ]);

        WorkShift::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'shift_date' => $request->shift_date,
            ],
            [
                'shift_type' => $request->shift_type,
                'notes' => $request->notes,
            ]
        );

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Admin Set Work Shift',
            'details' => "Admin menetapkan shift '{$request->shift_type}' untuk user #{$request->user_id} tanggal {$request->shift_date}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Jadwal shift kerja staf berhasil disimpan!');
    }

    /**
     * Admin Resolve Complaint
     */
    public function resolveComplaint(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|string|in:pending,in_progress,resolved',
            'resolution' => 'required|string',
        ]);

        $complaint->update([
            'status' => $request->status,
            'resolution' => $request->resolution,
        ]);

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Admin Resolve Complaint',
            'details' => "Admin memperbarui komplain #{$complaint->id} menjadi status '{$request->status}'",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Status dan resolusi komplain pelanggan berhasil disimpan!');
    }

    /**
     * Clear System Security Audit Trail Logs
     */
    public function clearLogs(Request $request)
    {
        SystemLog::truncate();

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Clear System Logs',
            'details' => 'Admin membersihkan seluruh log audit keamanan sistem.',
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Seluruh log audit keamanan sistem berhasil dibersihkan!');
    }
}

