<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'id_customer';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_customer',
        'nama_pemesan',
        'no_telp',
        'alamat',
    ];

    public function getIdCustomerDisplayAttribute(): string
    {
        if ($this->id_customer === null || $this->id_customer === '') {
            return '-';
        }

        if (str_starts_with($this->id_customer, 'customer-')) {
            return $this->id_customer;
        }

        return 'customer-' . $this->id_customer;
    }
}
