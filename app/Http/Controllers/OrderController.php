<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\Jasa;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar order sesuai status produksi.
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

        return view('admin.Order.index', [
            'orders' => $query->latest()->get(),
            'customers' => customer::orderBy('nama_pemesan')->get(),
            'jasas' => Jasa::orderBy('nama_jasa')->get(),
            'nextKodeOrder' => $this->generateKodeOrder(now()),
            'statusPembayaran' => Order::STATUS_PEMBAYARAN,
            'statusProduksi' => Order::STATUS_PRODUKSI,
            'statusLabel' => $statusLabel,
            'jenisPembayaran' => Order::JENIS_PEMBAYARAN,
            'kondisiDesain' => Order::KONDISI_DESAIN,
            'statusDesain' => Order::STATUS_DESAIN,
        ]);
    }

    /**
     * Simpan order baru.
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);
        // TAMBAHAN: UPLOAD FILE
        $buktiTransfer = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiTransfer = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

        $fileDesainCustomer = null;
        if ($request->hasFile('file_desain_customer')) {
            $fileDesainCustomer = $request->file('file_desain_customer')->store('desain_customer', 'public');
        }

        $fileMockup = null;
        if ($request->hasFile('file_mockup')) {
            $fileMockup = $request->file('file_mockup')->store('mockup', 'public');
        }

        $customer = customer::findOrFail($data['id_customer']);
        $tarif = null;
        if (!empty($data['jasa_id'])) {
            $jasa = Jasa::findOrFail($data['jasa_id']);
            $tarif = $jasa->tarif;
        }

        // DIUBAH: kirim file ke payload
        $payload = $this->buildPayload(
            $data,
            $customer->nama_pemesan,
            $tarif,
            $buktiTransfer,
            $fileDesainCustomer,
            $fileMockup
        );
        $payload['kode_order'] = $this->generateKodeOrder($data['tanggal_pesan']);

        Order::create($payload);

        return back()->with('success', 'Order berhasil ditambahkan.');
    }

    /**
     * Update order.
     */
    public function update(Request $request, Order $order)
    {
        $data = $this->validateData($request, $order);

        // Safety: if some optional inputs are not sent, keep existing values
        $defaults = [
            'jasa_id' => $order->jasa_id,
            'ukuran' => $order->ukuran,
            'jumlah' => $order->jumlah,
            'status_pembayaran' => $order->status_pembayaran,
            'jenis_pembayaran' => $order->jenis_pembayaran,
            'dp_amount' => $order->dp_amount,
            'kondisi_desain' => $order->kondisi_desain,
            'status_desain' => $order->status_desain,
            'catatan_revisi' => $order->catatan_revisi,
            'tanggal_target_selesai' => $order->tanggal_target_selesai,
            'tanggal_mulai_proses' => $order->tanggal_mulai_proses,
            'tanggal_selesai_proses' => $order->tanggal_selesai_proses,
            'status_produksi' => $order->status_produksi,
            'tanggal_diambil' => $order->tanggal_diambil,
            'catatan' => $order->catatan,
        ];
        foreach ($defaults as $key => $value) {
            if (!array_key_exists($key, $data)) {
                $data[$key] = $value;
            }
        }

        $customer = customer::findOrFail($data['id_customer']);
        $tarif = null;
        if (!empty($data['jasa_id'])) {
            $jasa = Jasa::findOrFail($data['jasa_id']);
            $tarif = $jasa->tarif;
        }
        $buktiTransfer = $order->bukti_transfer;

        if ($request->hasFile('bukti_transfer')) {
            $buktiTransfer = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

        $fileDesainCustomer = $order->file_desain_customer;
        if ($request->hasFile('file_desain_customer')) {
            $fileDesainCustomer = $request->file('file_desain_customer')->store('desain_customer', 'public');
        }

        $fileMockup = $order->file_mockup;
        if ($request->hasFile('file_mockup')) {
            $fileMockup = $request->file('file_mockup')->store('mockup', 'public');
        }
        // //DIUBAH: kasih null untuk file (biar gak error)
        $payload = $this->buildPayload(
            $data,
            $customer->nama_pemesan,
            $tarif,
            $buktiTransfer,
            $fileDesainCustomer,
            $fileMockup
        );

        $order->update($payload);

        return back()->with('success', 'Order berhasil diperbarui.');
    }

    /**
     * Hapus order.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Order berhasil dihapus.');
    }

    /**
     * Validasi input.
     */
    private function validateData(Request $request, ?Order $order = null): array
    {
        $input = $request->all();
        foreach ([
            'jasa_id',
            'ukuran',
            'jumlah',
            'status_pembayaran',
            'jenis_pembayaran',
            'dp_amount',
            'tanggal_target_selesai',
            'tanggal_mulai_proses',
            'tanggal_selesai_proses',
            'tanggal_diambil',
            'catatan_revisi',
        ] as $key) {
            if (array_key_exists($key, $input) && $input[$key] === '') {
                $input[$key] = null;
            }
        }

        $validator = Validator::make($input, [
            'id_customer' => ['required', 'string', 'exists:customers,id_customer'],
            'nama_kemasan' => ['required', 'string', 'max:100'],
            'tanggal_pesan' => ['required', 'date'],
            'tanggal_target_selesai' => ['nullable', 'date'],

            // DESAIN
            'kondisi_desain' => ['required', 'integer', Rule::in([1, 2])],
            'status_desain' => ['required', 'integer', Rule::in([1, 2, 3])],
            'catatan_revisi' => ['nullable', 'string', 'max:2000'],
            'file_desain_customer' => ['nullable', 'file', 'mimes:jpg,png,pdf', 'max:2048'],
            'file_mockup' => ['nullable', 'file', 'mimes:jpg,png,pdf', 'max:2048'],

            // ORDER DETAIL (boleh kosong sebelum desain disetujui)
            'jasa_id' => ['nullable', 'integer', 'exists:jasas,id'],
            'ukuran' => ['nullable', 'string', 'max:256'],
            'jumlah' => [
                'bail',
                'nullable',
                'string',
                'regex:/^\d+$/',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $value = trim((string) $value);

                    // hilangkan nol depan
                    $value = ltrim($value, '0');
                    $value = $value === '' ? '0' : $value;

                    // batas digit (max 10 digit)
                    if (strlen($value) > 10) {
                        $fail('Jumlah maksimal 10 digit!');
                    }

                    // batas sesuai INT(11)
                    if ((int)$value > 2147483647) {
                        $fail('Jumlah terlalu besar!');
                    }
                },
            ],

            // PEMBAYARAN
            'status_pembayaran' => ['nullable', 'integer', Rule::in([1, 2, 3])],
            'jenis_pembayaran' => ['nullable', 'integer', Rule::in([1, 2])],
            'dp_amount' => ['nullable', 'numeric', 'min:0'],
            'bukti_transfer' => ['nullable', 'file', 'mimes:jpg,png,pdf', 'max:2048'],

            // PRODUKSI
            'tanggal_mulai_proses' => ['nullable', 'date'],
            'tanggal_selesai_proses' => ['nullable', 'date'],
            'status_produksi' => ['required', 'integer', Rule::in([1, 2, 3])],
            'tanggal_diambil' => ['nullable', 'date'],

            // LAINNYA
            'catatan' => ['nullable', 'string', 'max:2000'],
        ]);

        $validator->sometimes('catatan_revisi', ['required'], function ($input) {
            return (int) ($input->kondisi_desain ?? 1) === 2 && (int) ($input->status_desain ?? 1) === 2;
        });

        $validator->sometimes(['jasa_id', 'status_pembayaran'], ['required'], function ($input) {
            return (int) ($input->kondisi_desain ?? 1) === 2 && (int) ($input->status_desain ?? 1) === 3;
        });

        $validator->sometimes('jumlah', ['required'], function ($input) {
            $designApproved = (int) ($input->kondisi_desain ?? 1) === 2 && (int) ($input->status_desain ?? 1) === 3;
            $hasJasa = ($input->jasa_id ?? null) !== null;

            return $designApproved && $hasJasa;
        });

        $validator->sometimes('dp_amount', ['required'], function ($input) {
            $designApproved = (int) ($input->kondisi_desain ?? 1) === 2 && (int) ($input->status_desain ?? 1) === 3;
            return $designApproved && (int) ($input->status_pembayaran ?? 1) === 3;
        });

        $validator->sometimes('jenis_pembayaran', ['required'], function ($input) {
            $designApproved = (int) ($input->kondisi_desain ?? 1) === 2 && (int) ($input->status_desain ?? 1) === 3;
            return $designApproved && in_array((int) ($input->status_pembayaran ?? 1), [2, 3], true);
        });

        $validator->sometimes('tanggal_mulai_proses', ['required'], function ($input) {
            $designApproved = (int) ($input->kondisi_desain ?? 1) === 2 && (int) ($input->status_desain ?? 1) === 3;
            return $designApproved && (int) ($input->status_produksi ?? 1) === 2;
        });

        $validator->sometimes('tanggal_selesai_proses', ['required'], function ($input) {
            $designApproved = (int) ($input->kondisi_desain ?? 1) === 2 && (int) ($input->status_desain ?? 1) === 3;
            return $designApproved && (int) ($input->status_produksi ?? 1) === 3;
        });

        $validator->after(function ($validator) use ($request, $order) {
            $kondisiDesain = $request->input('kondisi_desain', $order?->kondisi_desain);
            $statusDesain = $request->input('status_desain', $order?->status_desain);
            $statusPembayaran = (int) ($request->input('status_pembayaran') ?? 1);
            $jenisPembayaran = $request->input('jenis_pembayaran');
            $statusProduksi = (int) ($request->input('status_produksi') ?? 1);

            // 8) Status desain otomatis "Menunggu desain" jika kondisi desain belum ada desain
            // (server-side: sanitasi dilakukan di buildPayload; di sini tidak dibuat error)

            $designApproved = (int)$kondisiDesain === 2 && (int)$statusDesain === 3;

            // 7) Status produksi 2/3 hanya jika desain disetujui
            if (!$designApproved && in_array($statusProduksi, [2, 3], true)) {
                $validator->errors()->add('status_produksi', 'Status produksi "Sedang diproses" / "Selesai" hanya bisa dipilih jika desain sudah ada dan disetujui.');
            }

            // 4) Tanggal produksi tidak bisa diisi jika desain belum disetujui
            if (!$designApproved) {
                if ($request->filled('tanggal_mulai_proses')) {
                    $validator->errors()->add('tanggal_mulai_proses', 'Tanggal mulai proses hanya bisa diisi jika desain sudah ada dan disetujui.');
                }
                if ($request->filled('tanggal_selesai_proses')) {
                    $validator->errors()->add('tanggal_selesai_proses', 'Tanggal selesai proses hanya bisa diisi jika desain sudah ada dan disetujui.');
                }
            }

            // 2) Bukti transfer wajib jika jenis pembayaran transfer (hanya saat DP/Lunas dan desain disetujui)
            $jenisPembayaranInt = $jenisPembayaran !== null ? (int) $jenisPembayaran : null;
            $requiresJenisPembayaran = $designApproved && in_array($statusPembayaran, [2, 3], true);
            $requiresBuktiTransfer = $requiresJenisPembayaran && $jenisPembayaranInt === 2;
            if ($requiresBuktiTransfer) {
                $hasNewFile = $request->hasFile('bukti_transfer');
                $hasExisting = $order?->bukti_transfer ? true : false;
                if (!$hasNewFile && !$hasExisting) {
                    $validator->errors()->add('bukti_transfer', 'Upload bukti transfer wajib diisi jika jenis pembayaran "Transfer".');
                }
            }
        });

        return $validator->validate();
    }

    /**
     * Susun data siap simpan/update.
     */
    // DIUBAH: tambah parameter file
    private function buildPayload(array $data, string $namaPemesan, $tarif, $buktiTransfer, $fileDesainCustomer, $fileMockup): array
    {
        $data['nama_pemesan'] = $namaPemesan;
        $data['jasa_id'] = $data['jasa_id'] ?? null;
        $data['jumlah'] = $data['jumlah'] ?? null;

        $kondisiDesain = (int) ($data['kondisi_desain'] ?? 1);
        $statusDesain = (int) ($data['status_desain'] ?? 1);
        if ($kondisiDesain === 1) {
            // 8) otomatis menunggu desain
            $statusDesain = 1;
        }
        $data['kondisi_desain'] = $kondisiDesain;
        $data['status_desain'] = $statusDesain;

        $designApproved = (int)$kondisiDesain === 2 && (int)$statusDesain === 3;

        $data['tarif'] = $tarif;
        if ($tarif !== null && $data['jumlah'] !== null) {
            $data['total_tagihan'] = $tarif * (int) $data['jumlah'];
        } else {
            $data['total_tagihan'] = null;
        }

        $dpInput = max(0, $data['dp_amount'] ?? 0);
        $data['status_pembayaran'] = (int) ($data['status_pembayaran'] ?? 1);
        switch ($data['status_pembayaran']) {
            case 2:
                $data['dp_amount'] = (float) ($data['total_tagihan'] ?? 0);
                break;
            case 3:
                $data['dp_amount'] = min((float) $dpInput, (float) ($data['total_tagihan'] ?? 0));
                break;
            default:
                $data['dp_amount'] = 0;
                break;
        }

        // TAMBAHAN
        $data['jenis_pembayaran'] = (int) ($data['jenis_pembayaran'] ?? 1);
        $data['catatan_revisi'] = $data['catatan_revisi'] ?? null;

        // 4,7) produksi hanya jika desain disetujui
        if (!$designApproved) {
            $data['status_produksi'] = 1;
            $data['tanggal_mulai_proses'] = null;
            $data['tanggal_selesai_proses'] = null;
        }

        $data['bukti_transfer'] = $buktiTransfer;
        $data['file_desain_customer'] = $fileDesainCustomer;
        $data['file_mockup'] = $fileMockup;

        return $data;
    }

    /**
     * Generate kode order dengan format order-x. pakai tahun pesan
     */
    private function generateKodeOrder($tanggalPesan = null): string
    {
        // pakai tanggal_pesan, kalau kosong pakai hari ini
        $tanggal = $tanggalPesan ? date('Y-m-d', strtotime($tanggalPesan)) : now();

        $tahunFull = date('Y', strtotime($tanggal));
        $tahun = date('y', strtotime($tanggal));

        // ambil order terakhir di tahun itu
        $lastOrder = Order::whereYear('tanggal_pesan', $tahunFull)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastOrder && $lastOrder->kode_order) {
            $parts = explode('-', $lastOrder->kode_order);
            $lastNumber = isset($parts[2]) ? (int) $parts[2] : 0;
            $urutan = $lastNumber + 1;
        } else {
            $urutan = 1;
        }

        return 'ORD-' . $tahun . '-' . $urutan;
    }
}
