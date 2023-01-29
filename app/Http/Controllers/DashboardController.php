<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Daftar;
use App\Models\Mahasiswa;
use App\Models\NewMahasiswa;
use App\Models\Praktikum;
use App\Models\PraktikumMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Inline\Parser\NewlineParser;
use App\Models\Periode;

class DashboardController extends BaseController
{
    public function index ()
    {
            $periode = Periode::where('status_periode', 'Aktif')->first();
            $data = Praktikum::whereHas('periode', function($q){
                $q->where('status_periode','Aktif');
            })->get();

            $datamhs = PraktikumMahasiswa::whereHas('praktikum', function($q){
                $q->whereHas('periode', function($q1){
                    $q1->where('status_periode', 'Aktif');
                });
            })->count();

            //dd($data->all());
            // $dataMhs = NewMahasiswa::whereHas('praktikumMhs', function ($q){
            //     $q->whereHas('praktikum', function ($q1){
            //         $q1->whereHas('periode', function ($q2){
            //             $q2->where('status_periode', 'Aktif');
            //         });
            //     });
            // })->where('user_id', Auth()->user()->id)
            // ->get();
            //dd($dataMhs->toArray());

            return view ('/dashboard.index', compact ('data','datamhs','periode'));
    }
}
