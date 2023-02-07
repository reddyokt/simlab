<?php

namespace App\Http\Controllers;

use App\Models\AlatPraktikum;
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
use Svg\Tag\Rect;

class ModulController extends BaseController
{
    public function index()
    {

        $role = auth()->user()->role->role_name;

        $dataModul = Modul::whereHas('praktikum', function ($q) use($role){
            if($role == 'Ka Unit'){
                $q = $q->where('dosen_id', auth()->user()->dosen->id_dosen);
            }
            $q->whereHas('periode', function ($q1) use($role){
                $q1->where('status_periode', 'Aktif');
            });
        })->get();

        //dd($dataModul);
        return view ('modul.index', compact('dataModul'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
    {

        $alat = AlatPraktikum::all();
        $bahan = Bahan::all();
        $kelas = Kelas::all();
        $praktik = Praktikum::all();

        return view ('modul.createmodul', compact('alat','kelas', 'bahan', 'praktik'));

    }


    public function storemodul(Request $request)
    {
        //dd($request);
       $else = Modul::where('praktikum_id', $request->praktikum_id)->count('praktikum_id');
       //dd ($else);
       $prk = Praktikum::where('id_praktikum', $request->praktikum_id)->first();
       $kls = Kelas::where('id_kelas', $prk->kelas_id)->sum('jumlah_modul');
        //dd($kls);
        if($else >= $kls){
            return redirect()->back()->withErrors('Tidak bisa membuat lagi, Jumlah Modul Pada kelas ini Sudah Mencukupi');
        }
    //    $jmlmodul = Kelas::where('id_kelas', $request->kelas_id->kelas_id)->sum('jumlah_modul');
    //    dd($jmlmodul);

       $data = $request->all();
       //dd($data);
       $tanggal = \DateTime::createFromFormat('m/d/Y', $request->tanggal_praktek);
       $newtanggal = $tanggal->format('Y-m-d');

       $modul = new Modul;
       $modul->nama_modul=$data['nama_modul'];
       $modul->praktikum_id=$data['praktikum_id'];
       $modul->tanggal_praktek=$newtanggal;
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
        $tanggal = \DateTime::createFromFormat('m/d/Y', $request->tanggal_praktek);
        $newtanggal = $tanggal->format('Y-m-d');


        $modul = Modul::find($id_modul);
        $modul->nama_modul=$data['nama_modul'];
        $modul->praktikum_id=$data['kelas_id'];
        $modul->tanggal_praktek=$newtanggal;
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
        //dd($request->all());
        $data = Modul::find($id);
        $data =CatatanModul::create([
            'modul_id' => $id,
            'isi_catatan'=> $request->catatan,
            'user_id' => auth()->id()
        ]);
        return redirect ('/modul')->with('success', 'Catatan berhasil dibuat');
    }

    public function editcatatanmodul(Request $request)
    {
        //dd($request->all());
        $data = CatatanModul::where('modul_id', $request->modul_id)->first();
        $data->update([
            'isi_catatan'=> $request->editcatatan,
            'user_id' => auth()->id()
        ]);
        return redirect ('/modul')->with('success', 'Catatan berhasil diubah');
    }


}
