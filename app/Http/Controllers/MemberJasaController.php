<?php

namespace App\Http\Controllers;

use App\Models\Jasa;

class MemberJasaController extends Controller
{
    /**
     * Read-only list of jasa for members.
     */
    public function index()
    {
        return view('member.BiayaJasa.index', [
            'jasas' => Jasa::get(),
        ]);
    }
}
