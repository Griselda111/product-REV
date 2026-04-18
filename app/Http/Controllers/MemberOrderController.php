<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\Jasa;
use App\Models\Order;
use Illuminate\Http\Request;

class MemberOrderController extends Controller
{
    /**
     * Tampilkan daftar order untuk member sesuai status produksi.
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'jasa']);
        $statusProduksi = $request->status_produksi ?? null;
        $statusLabel = null;

        // Filter berdasarkan status_produksi jika ada di query parameter
        if ($statusProduksi) {
            $query->where('status_produksi', $statusProduksi);
            $statusLabel = Order::STATUS_PRODUKSI[$statusProduksi] ?? null;
        }

        return view('member.Order.index', [
            'orders' => $query->latest()->get(),
            'statusLabel' => $statusLabel,
        ]);
    }
}
