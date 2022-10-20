<?php

namespace App\Http\Controllers;

use App\Models\Alats;
use App\Models\Lemari;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c2a = DB::table('alat')
            ->join('lemari','lemari.id_lemari','=','alat.lemari_id')
            ->join('lokasi', 'lokasi.id_lokasi', '=', 'lemari.id_lokasi')
            ->whereIn('alat.jenis',['c2a'])
            ->get();

        $c2b = DB::table('lokasi')
            ->join('alat','alat.lokasi_id','=','lokasi.id_lokasi')
            ->whereIn('alat.jenis',['c2b'])
            ->get();

     return view ('inventory.alat.index', compact('c2b','c2a'));

    }

    public function createalatc2a()
    {
        $lemaris = Lemari::all();

        return view ('inventory.alat.createalatc2a', compact('lemaris'));
    }

    public function storealatc2a(Request $request)

    {
        //return $request;
        $c2a =  $request->validate([
            'nama_alat' => 'required|max:255',
            'merk' => '',
            'ukuran' => '',
            'jumlah' => 'required|max:255',
            'rusak' => 'required',
            'lemari_id' => 'required',
            'baris' => 'required|numeric|min:1',
            'kolom' => 'required|numeric|min:1'
       ]);

       $c2a = new Alats();
       $c2a->nama_alat = $request->nama_alat;
       $c2a->merk= $request->merk;
       $c2a->ukuran= $request->ukuran;
       $c2a->jumlah= $request->jumlah;
       $c2a->rusak = $request->rusak;
       $c2a->lemari_id = $request->lemari_id;
       $c2a->baris = $request->baris;
       $c2a->kolom = $request->kolom;
       $c2a->jenis = ('c2a');

       $c2a->save();

        return redirect ('/alat')->with('success', 'Data Alat berhasil ditambahkan');

    }

    public function createalatc2b()
    {
        $lokasi = Lokasi::all();

        return view ('inventory.alat.createalatc2b', compact('lokasi'));
    }

    public function storealatc2b(Request $request)

    {
        //return $request;
        $c2b =  $request->validate([
            'nama_alat' => 'required|max:255',
            'merk' => '',
            'ukuran' => '',
            'jumlah' => 'required|max:255',
            'pabrikan'=>'',
            'rusak' => 'required',
            'lokasi_id'=>'required'
       ]);

       $c2b = new Alats();
       $c2b->nama_alat = $request->nama_alat;
       $c2b->merk= $request->merk;
       $c2b->ukuran= $request->ukuran;
       $c2b->jumlah= $request->jumlah;
       $c2b->pabrikan= $request->pabrikam;
       $c2b->rusak = $request->rusak;
       $c2b->lokasi_id= $request->lokasi_id;
       $c2b->jenis = ('c2b');

       $c2b->save();

        return redirect ('/alat')->with('success', 'Data Alat berhasil ditambahkan');

    }

}
