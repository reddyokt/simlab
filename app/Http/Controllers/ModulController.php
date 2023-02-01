<?php

namespace App\Http\Controllers;

use App\Models\Alats;
use App\Models\Bahan;
use App\Models\Modul;
use App\Models\Periode;
use App\Models\c2a_alat;
use App\Models\c2b_alat;
use App\Models\CatatanModul;
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

        $dataModul = Modul::all();
        $catatan = CatatanModul::all();
           return view ('modul.index', compact('dataModul','catatan'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
    {

        $alat = Alats::all();
        $bahan = Bahan::all();
        $kelas = Kelas::all();
        $praktik = Praktikum::all();

        return view ('modul.createmodul', compact('alat','kelas', 'bahan', 'praktik'));

    }


    public function storemodul(Request $request)
    {
       $data = $request->all();
       //dd($data);

       $modul = new Modul;
       $modul->nama_modul=$data['nama_modul'];
       $modul->praktikum_id=$data['kelas_id'];
       $modul->tanggal_praktek=$data['tanggal_praktek'];
       $modul->save();

        foreach ($data['id_alat'] as $index=>$alat){
            $x = ['modul_id'=>$modul->id_modul,
                'alat_id'=>$alat,
                'bahan_id'=>0,
                'jumlah_bahan'=>$data['jumlah_alat'][$index],
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

    public function usemodul(Request $request, $id_modul)
    {
        $modul = Modul::find($id_modul);
        $bahanmember = $modul->membermodul()->where('bahan_id','!=',0)->get();
        //dd($bahan->toArray());
        $msg = '';
        foreach ($bahanmember as $b) {
            $bahan = Bahan::find($b->bahan_id);
            $bahan->jumlah = $bahan->jumlah - $b->jumlah_bahan;
            $msg = $msg."Nama Bahan : {$bahan->nama_bahan} Jumlah Dipakai : {$b->jumlah_bahan} Sisa Bahan : {$bahan->jumlah} <br>\n";
            $bahan->save();
        }
        $modul->used = true;
        $modul->save();

        return redirect ('/modul')->with('success', $msg);
    }

    public function showmodul($id_modul)
    {
        $modul = Modul::find($id_modul);
        $bahanmember = $modul->membermodul()->where('bahan_id','!=',0)->get();
        $alat = Alats::all();
        $bahan = Bahan::all();
        $kelas = Kelas::all();
        $praktik = Praktikum::all();

        //dd($alat->toArray(), $modul->alat->toArray());
        return view ('modul.editmodul', compact('modul', 'bahanmember','alat','kelas', 'bahan', 'praktik'));
    }

    public function editmodul(Request $request, $id_modul)
    {
        //dd($request->all());
        $membermodul = Membermodul::where('modul_id',$id_modul)->delete();

        $data = $request->all();

        $modul = Modul::find($id_modul);
        $modul->nama_modul=$data['nama_modul'];
        $modul->praktikum_id=$data['kelas_id'];
        $modul->tanggal_praktek=$data['tanggal_praktek'];
        $modul->save();

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

         return redirect ('/modul')->with('success', 'Data Modul berhasil diubah');
    }

    public function catatanmodul(Request $request, $id)
    {
        dd($request->all());
        $data = Modul::find($id);
        $data =CatatanModul::create([
            'modul_id' => $id,
            'isi_catatan'=> $request->catatan,
            'user_id' => auth()->id()
        ]);
        return redirect ('/modul')->with('success', 'Catatan berhasil dibuat');
    }

}
