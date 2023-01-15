<?php

namespace App\Http\Controllers;

use App\Models\Alats;
use App\Models\Bahan;
use App\Models\Modul;
use App\Models\Periode;
use App\Models\c2a_alat;
use App\Models\c2b_alat;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Praktikum;
use App\Models\Membermodul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;

class ModulController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        //    $member = DB::table('membermodul')
        //    ->join('modul', 'modul.id_modul', '=' ,'membermodul.modul_id')
        //    ->join ('alat', 'alat.id_alat', '=' , 'membermodul.alat_id')
        //    ->get();


        //    $dataModul = DB::table('modul')
        //     ->join('praktikum','praktikum.id_praktikum','=','modul.kelas_id')
        //     ->join('dosen', 'dosen.id_dosen', '=', 'praktikum.dosen_id')
        //     ->get();
        $dataModul = Modul::all();

           return view ('modul.index', compact('dataModul'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
    {
      //  $dataModuls = DB::table('modul')
        //->join('praktikum','praktikum.id_praktikum','=','modul.kelas_id')
        //->join('c2a_alat','c2a_alat.id_alat_c2a','=','modul.alatc2a_id')
        //->join('c2b_alat','c2b_alat.id_alat_c2b','=','modul.alatc2b_id')
        //->whereIn('praktikum.is_active',['YA'])
        //->get();

        $alat = Alats::all();
        $bahan = Bahan::all();
        $kelas = Kelas::all();
        $praktik = Praktikum::all();


        return view ('modul.createmodul', compact('alat','kelas', 'bahan', 'praktik'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storemodul(Request $request)
    {
    //     return $request;
    //     $modul =  $request->validate([
    //         'nama_modul' => 'required|max:255',
    //         'kelas_id'=>'required',
    //         'tanggal_praktek' => 'required|date'

    //    ]);

    //    $modul = new Modul;
    //    $modul->nama_modul = $request->nama_modul;
    //    $modul->kelas_id= $request->kelas_id;
    //    $modul->tanggal_praktek= $request->tanggal_praktek;

       $data = $request->all();
       //dd($data);

       $modul = new Modul;
       $modul->nama_modul=$data['nama_modul'];
       $modul->kelas_id=$data['kelas_id'];
       $modul->tanggal_praktek=$data['tanggal_praktek'];
       $modul->save();

    //    if (is_countable($data['alat']) && count($data['alat'])>0) {
    //     foreach ($data['alat'] as $item =>$value) {
    //     $data2 = array(
    //         'modul_id'=>$modul->id_modul,
    //         'alat_id'=>$data['alat'][$item],

    //     );
    //     Membermodul::create($data2);
    //     }

    //     }

    foreach ($data['alat'] as $index=>$alat){
        $x = ['modul_id'=>$modul->id_modul,
            'alat_id'=>$data['alat'][$index],
            'bahan_id'=>0,
            'jumlah_bahan'=>0,
    ];
        Membermodul::create($x);
    }

    foreach ($data['id_bahan'] as $index=>$bahan){
        $x = ['modul_id'=>$modul->id_modul,
             'bahan_id'=>$bahan,
             'alat_id'=>0,
             'jumlah_bahan'=>$data['jumlah_bahan'][$index],
    ];
        Membermodul::create($x);
    }

        return redirect ('/modul')->with('success', 'Data Modul berhasil ditambahkan');
    }

    // public function addItem($id_modul)
    // {
    //     $alatA = DB::table('alat')
    //     ->whereIn('alat.jenis',['c2a'])
    //     ->get();

    //     $alatB = DB::table('alat')
    //     ->whereIn('alat.jenis',['c2b'])
    //     ->get();
    //     $modul = Modul::find($id_modul);
    //     //$alat = Alats::all();
    //     return view('modul.addItem', compact('modul','alatA','alatB'));

    // }

    public function storeItem(Request $request)
    {
        //return $request;
        $item =  $request->validate([
        'modul_id' => 'required',
        'alatc2a' => 'required',
        'alatc2b' => 'required'
   ]);
        $item= new Membermodul ();
        $item->modul_id=$request->modul_id;
        $item->alat_id =$request->alatc2a;
        $item->alat_id =$request->alatc2b;
        $item->save();
    }

}
