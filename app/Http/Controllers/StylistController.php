<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Portfolio;
use App\Models\ClientNote;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StylistController extends Controller
{
    /**
     * Update Work Status (Available, On Duty, Break, Off)
     */
    public function updateWorkStatus(Request $request)
    {
        $request->validate([
            'work_status' => 'required|string|in:Available,On Duty,Break,Off',
        ]);

        $user = Auth::user();
        $user->update(['work_status' => $request->work_status]);

        SystemLog::create([
            'user_id' => $user->id,
            'action' => 'Update Work Status',
            'details' => "Stylist {$user->name} mengubah status kerja menjadi {$request->work_status}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Status kerja berhasil diperbarui menjadi: ' . $request->work_status);
    }

    /**
     * Store new Portfolio item
     */
    public function storePortfolio(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();

        Portfolio::create([
            'stylist_id' => $user->id,
            'title' => $request->title,
            'image_path' => $request->image_url,
            'description' => $request->description,
        ]);

        SystemLog::create([
            'user_id' => $user->id,
            'action' => 'Add Portfolio',
            'details' => "Stylist {$user->name} mengunggah portofolio baru: {$request->title}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Portofolio potongan rambut berhasil diunggah!');
    }

    /**
     * Delete Portfolio item
     */
    public function deletePortfolio(Portfolio $portfolio)
    {
        $user = Auth::user();
        if ($portfolio->stylist_id !== $user->id && !in_array($user->role, ['admin', 'owner'])) {
            abort(403, 'Akses ditolak.');
        }

        $portfolio->delete();

        return back()->with('success', 'Foto portofolio berhasil dihapus.');
    }

    /**
     * Store Client Notes
     */
    public function storeClientNote(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'notes' => 'required|string',
        ]);

        $user = Auth::user();

        ClientNote::updateOrCreate(
            [
                'customer_id' => $request->customer_id,
                'stylist_id' => $user->id,
            ],
            [
                'notes' => $request->notes,
            ]
        );

        SystemLog::create([
            'user_id' => $user->id,
            'action' => 'Save Client Note',
            'details' => "Stylist {$user->name} menambahkan catatan preferensi gaya rambut untuk Pelanggan ID #{$request->customer_id}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Catatan preferensi pelanggan berhasil disimpan!');
    }
}
