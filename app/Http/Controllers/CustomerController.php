<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Tampilkan daftar customer.
     */
    public function index()
    {
        return view('admin.Customer.index', [
            'customers' => customer::get()
        ]);
    }

    /**
     * Simpan customer baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'nama_pemesan' => ['required', 'string', 'max:100'],
                'no_telp'      => ['nullable', 'string', 'max:20', 'regex:/^\d+$/'],
                'alamat'       => ['nullable', 'string', 'max:255'],
            ],
            [
                'no_telp.regex' => 'No. Telp harus diisi angka saja.',
            ]
        );

        $data['id_customer'] = $this->generateId();

        customer::create($data);

        return back()->with('success', 'Customer berhasil ditambahkan.');
    }

    /**
     * Update customer.
     */
    public function update(Request $request, customer $customer)
    {
        $data = $request->validate(
            [
                'nama_pemesan' => ['required', 'string', 'max:100'],
                'no_telp'      => ['nullable', 'string', 'max:20', 'regex:/^\d+$/'],
                'alamat'       => ['nullable', 'string', 'max:255'],
            ],
            [
                'no_telp.regex' => 'No. Telp harus diisi angka saja.',
            ]
        );

        $customer->fill($data)->save();

        return back()->with('success', 'Customer berhasil diperbarui.');
    }

    /**
     * Hapus customer.
     */
    public function destroy(customer $customer)
    {
        $customer->delete();

        return back()->with('success', 'Customer berhasil dihapus.');
    }

    /**
     * Generate ID customer dengan format customer-x (x angka berurutan).
     */
    private function generateId(): string
    {
        $lastNumber = customer::selectRaw(
            "MAX(CAST(REPLACE(id_customer, 'customer-', '') AS UNSIGNED)) as max_id"
        )->value('max_id');

        $nextNumber = $lastNumber ? ((int) $lastNumber + 1) : 1;

        return (string) $nextNumber;
    }
}
