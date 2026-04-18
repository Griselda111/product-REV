<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_order',
        'id_customer',
        'nama_pemesan',
        'nama_kemasan',
        'tanggal_pesan',
        'tanggal_target_selesai',
        'jasa_id',
        'tarif',
        'ukuran',
        'jumlah',
        'total_tagihan',
        'dp_amount',
        'status_pembayaran',
        'tanggal_mulai_proses',
        'tanggal_selesai_proses',
        'status_produksi',
        'tanggal_diambil',
        'catatan',
        //TAMBAHAN BARU
        'kondisi_desain',
        'jenis_pembayaran',
        'status_desain',
        'catatan_revisi',
        'file_desain_customer',
        'file_mockup',
        'bukti_transfer',
    ];

    protected $casts = [
        'tanggal_pesan' => 'date',
        'tanggal_target_selesai' => 'date',
        'tanggal_mulai_proses' => 'date',
        'tanggal_selesai_proses' => 'date',
        'tanggal_diambil' => 'date',
        'tarif' => 'decimal:2',
        'total_tagihan' => 'decimal:2',
        'dp_amount' => 'decimal:2',
    ];
    public const JENIS_PEMBAYARAN = [
        1 => 'Cash',
        2 => 'Transfer',
    ];

    public const KONDISI_DESAIN = [
        1 => 'Belum ada desain',
        2 => 'Sudah ada desain',
    ];

    public const STATUS_DESAIN = [
        1 => 'Menunggu desain',
        2 => 'Perlu revisi',
        3 => 'Disetujui',
    ];
    public const STATUS_PEMBAYARAN = [
        1 => 'Belum Lunas',
        2 => 'Lunas',
        3 => 'DP',
    ];

    public const STATUS_PRODUKSI = [
        1 => 'Belum diproses',
        2 => 'Sedang diproses',
        3 => 'Selesai',
    ];

    public function customer()
    {
        return $this->belongsTo(customer::class, 'id_customer', 'id_customer');
    }

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }

    public function getStatusPembayaranLabelAttribute(): string
    {
        return self::STATUS_PEMBAYARAN[$this->status_pembayaran] ?? '-';
    }

    public function getStatusProduksiLabelAttribute(): string
    {
        return self::STATUS_PRODUKSI[$this->status_produksi] ?? '-';
    }
    public function getJenisPembayaranLabelAttribute(): string
    {
        return self::JENIS_PEMBAYARAN[$this->jenis_pembayaran] ?? '-';
    }
    public function getKondisiDesainLabelAttribute(): string
    {
        return self::KONDISI_DESAIN[$this->kondisi_desain] ?? '-';
    }
    public function getStatusDesainLabelAttribute(): string
    {
        return self::STATUS_DESAIN[$this->status_desain] ?? '-';
    }
}
