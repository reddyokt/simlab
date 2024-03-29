<?php

namespace App\Http\Controllers\praktikan;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Modul;
use App\Models\Praktikum;
use App\Models\PraktikumMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $kelas = Praktikum::whereHas('periode', function ($q){
            $q->where('status_periode', 'Aktif');
        })->get();


        $role = auth()->user()->role->role_name;

        $data = Modul::whereHas('praktikum',function ($q) use($role) {
            if($role == 'Ka Unit'){
                $q = $q->where('dosen_id', auth()->user()->dosen->id_dosen);
            }
            if($role == 'Asisten Lab'){
                $q = $q->where('asisten_id', auth()->user()->id);
            }
            $q->whereHas('periode', function ($q2){
                $q2->where('status_periode','Aktif');
            });
        })->get();

        return view ('praktikan.absen.index', compact ('data','kelas'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        Absen::where('modul_id',$request->modul_id)->delete();
        foreach ($request->mahasiswa_id as $x){
            Absen::updateOrcreate([
                'mahasiswa_id'=>$x,
                'modul_id'=>$request->modul_id
            ]);
        }
        return redirect()->back()->with('success', 'Absen berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function show(Absen $absen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function edit(Absen $absen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absen $absen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absen $absen)
    {
        //
    }

    public function exportabsen(Request $request)
    {
        $praktikum = Praktikum::find($request->id_praktikum);
        $praktikumMhs = PraktikumMahasiswa::where('praktikum_id', $request->id_praktikum)->get();
        $data = Absen::whereHas('modul', function ($q) use($praktikum){
            $q->whereHas('praktikum', function ($q1) use($praktikum){
                $q1->whereHas('periode', function ($q2){
                    $q2->where('status_periode', 'aktif');
                })->where('id_praktikum',$praktikum->id_praktikum);
            });
        })->get();
        //dd($praktikumMhs->toArray());
        $pdf = Pdf::loadView('pdf.exportabsen', compact ('data','praktikum','praktikumMhs'));
        return $pdf->stream();
    }

    public function exportrekapabsen($id_praktikum_mahasiswa)
    {

        $data = PraktikumMahasiswa::find($id_praktikum_mahasiswa);
        $praktikum = Praktikum::find($data->praktikum_id);
        $absen = Absen::whereHas('modul', function ($q) use($data) {
            $q->whereHas('praktikum', function ($q1) use($data){
                $q1->where('id_praktikum', $data->praktikum_id);
            });
        })->where('mahasiswa_id', $data->mahasiswa_id)->get();

       // dd($absen);
        $pdf = Pdf::loadView('pdf.exportrekapabsen', compact ('data','absen','praktikum'));
        return $pdf->stream();
    }
}
