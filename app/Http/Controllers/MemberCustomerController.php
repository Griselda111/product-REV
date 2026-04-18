<?php

namespace App\Http\Controllers;

use App\Models\customer;

class MemberCustomerController extends Controller
{
    /**
     * Read-only list of customers for members.
     */
    public function index()
    {
        return view('member.Customer.index', [
            'customers' => customer::get(),
        ]);
    }
}
