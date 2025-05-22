<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequisitionController extends Controller
{
    
    public function create()
    {
        return view('admin.requisitions.create');
    }
}
