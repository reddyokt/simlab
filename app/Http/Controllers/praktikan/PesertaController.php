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
        $datakelompok = DB::table ('kelompok')
        ->join('kelompok_mhs', 'kelompok_mhs.kelompok_id', '=' ,'kelompok.id_kelompok')
        ->join('mahasiswa', 'mahasiswa.id_mahasiswa', '=' ,'kelompok_mhs.mahasiswa_id')
        ->join('praktikum','praktikum.id_praktikum', '=' ,'kelompok.kelas_id')
        ->get();

        return view ('praktikan.kelompok.index', compact('datakelompok'));
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
        $data = $request->all();


       $kelompok = new Kelompok();
       $kelompok->nama_kelompok=$data['nama_kelompok'];
       $kelompok->kelas_id=$data['kelas_id'];
       $kelompok->save();

       if (is_countable($data['id_mahasiswa']) && count($data['id_mahasiswa'])>0) {
        foreach ($data['id_mahasiswa'] as $item =>$value) {
        $data2 = array(
            'kelompok_id'=>$kelompok->id_kelompok,
            'mahasiswa_id'=>$data['id_mahasiswa'][$item],
        );
        KelompokMhs::create($data2);
        }

        }

        return redirect('/praktikan/kelompok');

    }

}
