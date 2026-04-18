<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use Illuminate\Http\Request;

class JasaController extends Controller
{
    private const TARIF_FORMAT_MESSAGE = 'Sesuaikan dengan format yang diminta. Gunakan angka tanpa titik pemisah ribuan dan maksimal 2 angka desimal (contoh: 20000 atau 0,18).';
    private const TARIF_MAX_MESSAGE = 'Tarif tidak boleh lebih dari 99999999,99.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.BiayaJasa.index', [
            'jasas' => Jasa::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'nama_jasa' => ['required', 'string', 'max:255'],
                'tarif' => [
                    'bail',
                    'required',
                    'string',
                    'max:30',
                    'regex:/^\d+(?:,\d{1,2})?$/',
                    function (string $attribute, mixed $value, \Closure $fail) {
                        $value = trim((string) $value);

                        $integerPart = explode(',', $value, 2)[0] ?? '';
                        $integerPart = ltrim($integerPart, '0');
                        $integerPart = $integerPart === '' ? '0' : $integerPart;

                        // Kolom DB: decimal(10,2) => max 8 digit sebelum koma (contoh: 99999999,99)
                        if (strlen($integerPart) > 8) {
                            $fail(self::TARIF_MAX_MESSAGE);
                        }
                    },
                ],
                'keterangan' => ['nullable', 'string', 'max:255'],
            ],
            [
                'tarif.regex' => self::TARIF_FORMAT_MESSAGE,
            ]
        );

        $data['tarif'] = str_replace(',', '.', trim($data['tarif']));

        Jasa::create($data);

        return back()->with('success', 'Data jasa berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jasa $jasa)
    {
        $data = $request->validate(
            [
                'nama_jasa' => ['required', 'string', 'max:255'],
                'tarif' => [
                    'bail',
                    'required',
                    'string',
                    'max:30',
                    'regex:/^\d+(?:,\d{1,2})?$/',
                    function (string $attribute, mixed $value, \Closure $fail) {
                        $value = trim((string) $value);

                        $integerPart = explode(',', $value, 2)[0] ?? '';
                        $integerPart = ltrim($integerPart, '0');
                        $integerPart = $integerPart === '' ? '0' : $integerPart;

                        // Kolom DB: decimal(10,2) => max 8 digit sebelum koma (contoh: 99999999,99)
                        if (strlen($integerPart) > 8) {
                            $fail(self::TARIF_MAX_MESSAGE);
                        }
                    },
                ],
                'keterangan' => ['nullable', 'string', 'max:255'],
            ],
            [
                'tarif.regex' => self::TARIF_FORMAT_MESSAGE,
            ]
        );

        $data['tarif'] = str_replace(',', '.', trim($data['tarif']));

        $jasa->update($data);

        return back()->with('success', 'Data jasa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jasa $jasa)
    {
        $jasa->delete();

        return back()->with('success', 'Data jasa berhasil dihapus.');
    }
}
