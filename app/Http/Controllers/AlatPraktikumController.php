<?php

namespace App\Http\Controllers;

use App\Models\AlatPraktikum;
use App\Models\Kategorialat;
use App\Models\Lokasi;
use App\Models\Lemari;
use Illuminate\Http\Request;

class AlatPraktikumController extends Controller
{
    public function index()
    {
        $alat = AlatPraktikum::all();

        //dd($alat);

        return view('inventory.alat.indexalat', compact ('alat'));
    }

    public function createalat()
    {
        $kategori = Kategorialat::all();
        $lokasi = Lokasi::all();
        $lemari = Lemari::all();

        return view('inventory.alat.createalat', compact ('kategori', 'lokasi', 'lemari'));
    }

    public function storealat(Request $request)
    {
        //dd($request->toArray());
       $alat = $request->validate([
        'kategori_id' => 'required',
        'nama_alat' => 'required|max:100',
        'merk' => 'max:50',
        'ukuran_alat' => '',
        'jumlah_alat' => '',
        'lokasi_id' => 'required',
        'lemari_id' => '',
        'baris'=> '',
        'kolom'=> '',
        'keterangan'=>''
       ]);

       $alat = new AlatPraktikum();
       $alat->kategori_alat_id = $request->kategori_id;
       $alat->nama_alat = $request->nama_alat;
       $alat->merk= $request->merk;
       $alat->ukuran= $request->ukuran;
       $alat->jumlah= $request->jumlah;
       $alat->lokasi_id=$request->lokasi_id;
       $alat->lemari_id = $request->lemari_id;
       $alat->baris = $request->baris;
       $alat->kolom = $request->kolom;
       $alat->keterangan = $request->keterangan;

       $alat->save();

        return redirect ('/indexalat')->with('success', 'Data Alat berhasil ditambahkan');
    }
}
