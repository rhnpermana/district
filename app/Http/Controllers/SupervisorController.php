<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WorkShift;
use App\Models\Complaint;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    /**
     * Store / Update Work Shift Schedule
     */
    public function storeShift(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shift_date' => 'required|date',
            'shift_type' => 'required|string|in:Pagi,Siang,Full,Off',
            'notes' => 'nullable|string',
        ]);

        $supervisor = Auth::user();

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
            'user_id' => $supervisor->id,
            'action' => 'Update Work Shift',
            'details' => "Supervisor {$supervisor->name} memperbarui jadwal shift user #{$request->user_id} tanggal {$request->shift_date} menjadi {$request->shift_type}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Jadwal shift kerja staf berhasil disimpan!');
    }

    /**
     * Audit / Adjust Product Stock
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
        ]);

        $supervisor = Auth::user();
        $oldStock = $product->stock;

        $product->update([
            'stock' => $request->stock,
            'min_stock' => $request->min_stock,
        ]);

        SystemLog::create([
            'user_id' => $supervisor->id,
            'action' => 'Stock Audit',
            'details' => "Supervisor {$supervisor->name} mengaudit stok '{$product->name}' dari {$oldStock} menjadi {$request->stock}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Stok produk '{$product->name}' berhasil diperbarui!");
    }

    /**
     * Resolve Customer Complaint
     */
    public function resolveComplaint(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|string|in:pending,in_progress,resolved',
            'resolution' => 'required|string',
        ]);

        $supervisor = Auth::user();

        $complaint->update([
            'status' => $request->status,
            'resolution' => $request->resolution,
        ]);

        SystemLog::create([
            'user_id' => $supervisor->id,
            'action' => 'Resolve Complaint',
            'details' => "Supervisor {$supervisor->name} memperbarui komplain #{$complaint->id} menjadi status '{$request->status}'",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Catatan resolusi komplain berhasil disimpan!');
    }
}
