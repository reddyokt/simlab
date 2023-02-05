<?php

namespace App\Http\Controllers;

use App\Models\Kategorialat;
use App\Models\Kelas;
use App\Models\Komposisinilai;
use App\Models\Masterdata;
use Illuminate\Http\Request;

class MasterdataController extends Controller
{
    //-------------------------------Master Data Nama Praktikum-----------------------------------//

    public function indexpraktikum ()
    {

        $data = Kelas::all();
        return view ('masterdata.indexnamapraktikum', compact ('data'));
    }

    public function createpraktikum()
    {
        return view('masterdata.createnamapraktikum');
    }

    public function storepraktikum(Request $request)
    {
        //dd($request->toArray());
        $kelas = $request->validate([
            'nama_kelas' => 'required|max:50|unique:kelas,nama_kelas',
            'kode_kelas' => 'required|string|min:7|max:7|unique:kelas,kode_kelas',
            'jumlah_modul' => 'required|integer|min:1'
        ]);
        $kelas = new Kelas();
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->kode_kelas = $request->kode_kelas;
        $kelas->jumlah_modul = $request->jumlah_modul;

        $kelas->save();
        return redirect('/masterdata/indexpraktikum')->with('success', 'Praktikum berhasil ditambah');
    }

    public function editpraktikum ($id_kelas)
    {
        $data = Kelas::find($id_kelas);
        return view ('masterdata.editnamapraktikum', compact ('data'));
    }

    public function storeeditpraktikum(Request $request, $id_kelas)
    {
        $kelas = Kelas::find($id_kelas);
        $kelas->update($request->all());
        return redirect('/masterdata/indexpraktikum')->with('success', 'Praktikum berhasil diubah');
    }
    public function activated($id_kelas)
    {
        $activated = Kelas::find($id_kelas);
        $activated->update(['is_active'=>'Y']);

        return redirect('/masterdata/indexpraktikum')->with('success', 'Praktikum berhasil diaktifkan');
    }

    public function deactivated($id_kelas)
    {
        $activated = Kelas::find($id_kelas);
        $activated->update(['is_active'=>'N']);

        return redirect('/masterdata/indexpraktikum')->with('success', 'Praktikum berhasil dinon-aktifkan');
    }

    //-------------------------------End Master Data Nama Praktikum--------------------------------//

    //-------------------------------Master Data Kategori Alat-------------------------------------//

    public function indexkategorialat()
    {
        $data = Kategorialat::all();
        return view ('masterdata.indexkategorialat', compact ('data'));
    }

    public function createkategorialat()
    {
        return view ('masterdata.createkategorialat');
    }
    //-------------------------------End Master Data Kategori Alat-------------------------------------//

     //-------------------------------Master Data Komposisi Nilai-------------------------------------//

    public function indexkomposisinilai()
    {
        $jumlah = Komposisinilai::sum('nilai_komponen');
        $data = Komposisinilai::all();
        return view ('masterdata.indexkomposisinilai', compact ('data','jumlah'));
    }

    public function storekomposisinilai(Request $request)
    {
        //dd($request->toArray());
        $else = Komposisinilai::where('id_komposisi_nilai', '!=' , $request->id_komposisi_nilai)->sum("nilai_komponen");
        $check = $else + $request->nilai_komponen;

        if ($check > 100)
        return redirect()->back()->withErrors('Jumlah Total Nilai Komponen Tidak Boleh Lebih dari 100!');
        $komposisi = Komposisinilai::find($request->id_komposisi_nilai);
        $komposisi->update([
            "nilai_komponen"=> $request->nilai_komponen
        ]);
        return redirect('/masterdata/indexkomposisinilai')->with('success', 'Nilai Komponen berhasil diubah');
    }



     //-------------------------------End Master Data Komposisi Nilai-------------------------------------//

}
