<?php

namespace App\Http\Controllers\praktikan;

use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
            $dataMhs = DB::table('mahasiswa')
            ->join('pendaftaran','pendaftaran.mahasiswa_id','=','mahasiswa.id_mahasiswa')
            ->join('praktikum','praktikum.id_praktikum','=','pendaftaran.kelas_id')
            ->whereIn('pendaftaran.status',['Diterima'])
            ->get();


            return view ('praktikan.peserta.index', compact('dataMhs'));
    }

    public function indexkelompok()
    {
        return view ('praktikan.kelompok.index');
    }

    public function createkelompok()
    {
        $dataMhs = DB::table('pendaftaran')
        -> join('mahasiswa', 'mahasiswa.id_mahasiswa', '=' , 'pendaftaran.mahasiswa_id')
        -> join('praktikum', 'praktikum.id_praktikum', '=' ,'pendaftaran.kelas_id')
        -> whereIn('pendaftaran.status', ['Diterima'])
        -> get();
        return view ('praktikan.kelompok.create', compact('dataMhs'));
    }

    public function storekelompok(Request $request)
    {
        //dd($request->all());

    }

}
