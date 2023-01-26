<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Daftar;
use App\Models\Mahasiswa;
use App\Models\Praktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends BaseController
{
    public function index ()
    {
            $data = Praktikum::whereHas('periode', function($q){
                $q->where('status_periode','Aktif');
            })->get();

            return view ('/dashboard.index', compact ('data'));
    }
}
