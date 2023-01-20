<?php

namespace App\Http\Controllers;

use App\Models\JawabanTugas;
use App\Models\JawabanUjian;
use App\Models\Modul;
use App\Models\Nilai;
use App\Models\PraktikumMahasiswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function indexnilaitugas()
    {
        $data = JawabanTugas::whereHas('tugas', function ($q) {
            $q->whereHas('modul', function ($q2) {
                $q2->whereHas('praktikum', function ($q3) {
                    $q3->whereHas('periode', function ($q4) {
                        $q4->where('status_periode', 'Aktif');
                    });
                });
            });
        }) ->get();
        //dd($data->toArray());
        return view('praktikan.nilai.indexnilaitugas', compact('data'));
    }
    public function isinilaitugas(Request $request)
    {
        //dd($request->all());

        $jawaban = JawabanTugas::find($request->id_jawaban_tugas);
        $jawaban->nilaitugas=$request->nilaitugas;
        $jawaban->save();

        return redirect ('/praktikan/nilaitugas')->with('success', 'Nilai berhasil ditambahkan');

    }

    public function indexnilaiakhir()
    {
        $data = JawabanUjian::whereHas('praktikum', function ($q) {
            $q->whereHas('periode', function ($q2) {
                $q2->whereHas('periode', function ($q3) {
                    $q3->where('status_periode', 'Aktif');
                    });
                });
            })->get();
        //dd($data->toArray());
        return view('praktikan.nilai.indexnilaiujian', compact('data'));
    }
}
