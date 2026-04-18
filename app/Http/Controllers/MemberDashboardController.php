<?php

namespace App\Http\Controllers;

use App\Models\Order;

class MemberDashboardController extends Controller
{
    /**
     * Dashboard untuk member (bukan admin).
     */
    public function index()
    {
        $belum = Order::where('status_produksi', 1)->count();
        $proses = Order::where('status_produksi', 2)->count();
        $selesai = Order::where('status_produksi', 3)->count();

        return view('member.dashboard', compact('belum', 'proses', 'selesai'));
    }
}
