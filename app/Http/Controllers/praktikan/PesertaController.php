<?php

namespace App\Http\Controllers\praktikan;

use DataTables;
use App\Models\Peserta;
use App\Models\Membermodul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use App\Models\KelompokMhs;
use App\Models\Periode;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PraktikanImport;
use App\Models\PraktikumMahasiswa;
use Dotenv\Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Barryvdh\DomPDF\Facade\Pdf;

class PesertaController extends Controller
{
    public function import(Request $request)
    {
        //dd($request->all());
        Excel::import(new PraktikanImport($request->periode_id), $request->file('dataimport'));

        return redirect ('praktikan/peserta');

        //dd($request->all());
    }
    public function index ()
    {
            $periode = Periode::where('status_periode','Aktif')
            ->get();
            $dataMhs = PraktikumMahasiswa::with([
                'mahasiswa','praktikum','praktikum.periode','praktikum.kelas'
            ])
            ->get();

            //dd ($dataMhs->toArray());
            return view ('praktikan.peserta.index', compact('dataMhs','periode'));
    }

    public function indexkelompok()
    {
        $datakelompok = PraktikumMahasiswa::
        whereHas('kelompok', function ($q){
            $q->whereHas('praktikum', function ($q2){
                $q2->whereHas('periode',function ($q3){
                    $q3->where('status_periode', 'Aktif');
                });
            });
        })
        ->get();
        //dd ($datakelompok->toArray());
        return view ('praktikan.kelompok.index', compact('datakelompok'));
    }

    public function createkelompok()
    {
        $dataMhs = PraktikumMahasiswa::with([
            'mahasiswa', 'praktikum.kelas', 'praktikum.periode'
            ])
            ->whereHas('praktikum', function ($q){
                $q->whereHas('periode', function ($q2){
                    $q2->where('status_periode','Aktif');
                });
            })->whereNull('kelompok_id')
            ->get();
        return view ('praktikan.kelompok.create', compact('dataMhs'));
    }

    public function storekelompok(Request $request)
    {
        //dd($request->all());
        $data = $request->all();

        $idMhs = [];
        $idPraktikum = [];

        foreach($request->id_mahasiswa as $x) {
            $y=explode('-',$x);
            $idMhs[]=$y[0];
            $idPraktikum[]=$y[1];
        }
        $field=[
                'id_praktikum'=>$idPraktikum,
                'idp'=>$idPraktikum[0]
        ];
        $rules=[
                'id_praktikum.*'=>'same:idp'
        ];
        $validator=FacadesValidator::make($field,$rules)->validate();


       $kelompok = new Kelompok();
       $kelompok->nama_kelompok=$data['nama_kelompok'];
       $kelompok->praktikum_id=$idPraktikum[0];
       $kelompok->save();

        foreach ($idMhs as $x){
            $praktikumMhs = PraktikumMahasiswa::where('mahasiswa_id', $x)
            ->where('praktikum_id',$idPraktikum[0])
            ->update(['kelompok_id'=>$kelompok->id_kelompok]);
        }
        return redirect('/praktikan/kelompok');

    }

    public function editkelompok($mahasiswa_id, $praktikum_id)
    {
        $data = PraktikumMahasiswa::where('mahasiswa_id', $mahasiswa_id)
        ->where('praktikum_id', $praktikum_id)
        ->first();

        $kelompok = Kelompok::where('praktikum_id', $praktikum_id)
        ->get();

        return view ('praktikan.kelompok.editkelompok', compact ('data','kelompok'));
    }

    public function updatekelompok(Request $request, $mahasiswa_id, $praktikum_id)
    {
       // dd ($request->all());
       $data = PraktikumMahasiswa::where('mahasiswa_id', $mahasiswa_id)
       ->where('praktikum_id', $praktikum_id)
       ->update(['kelompok_id'=>$request->kelompok_id]);

       return redirect('/praktikan/kelompok')->with('success', 'Data Kelompok berhasil diubah');
    }

    public function exportpeserta()
    {
        $periode = Periode::where('status_periode','Aktif')
        ->first();
        $dataMhs = PraktikumMahasiswa::with([
            'mahasiswa','praktikum','praktikum.periode','praktikum.kelas'
        ])
        ->get();

        $pdf = Pdf::loadView('pdf.exportpeserta', compact ('periode','dataMhs'));
        return $pdf->stream();
    }
    public function exportkelompok()
    {
        $periode = Periode::where('status_periode','Aktif')
        ->first();
        $datakelompok = PraktikumMahasiswa::
        whereHas('kelompok', function ($q){
            $q->whereHas('praktikum', function ($q2){
                $q2->whereHas('periode',function ($q3){
                    $q3->where('status_periode', 'Aktif');
                });
            });
        })
        ->get();

        $pdf = Pdf::loadView('pdf.exportkelompok', compact ('datakelompok','periode'));
        return $pdf->stream();
    }

}
