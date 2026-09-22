<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QueueBoardController extends Controller
{
    /**
     * Show real-time Queue Board display for waiting room screen
     */
    public function showBoard(Request $request)
    {
        $selectedBranch = $request->query('branch', 'Jakarta Kebayoran Baru');
        $today = Carbon::today()->toDateString();

        $todayBookings = Booking::with(['user', 'stylist'])
            ->where('booking_date', $today)
            ->where('branch', $selectedBranch)
            ->orderBy('booking_time', 'asc')
            ->get();

        // Currently Serving (status = approved / serving)
        $nowServing = $todayBookings->whereIn('status', ['approved', 'serving'])->values();

        // Arrived / Checked-in Waiting List
        $waitingList = $todayBookings->where('status', 'pending')->values();

        // Completed today
        $completedToday = $todayBookings->where('status', 'completed')->values();

        $activeStylists = User::where('role', 'hair stylist')->get();

        return view('queue.board', compact('nowServing', 'waitingList', 'completedToday', 'selectedBranch', 'activeStylists'));
    }
}
