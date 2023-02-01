<?php

namespace App\Http\Controllers;

use App\Models\Kategorialat;
use App\Models\Kelas;
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
        return redirect('/masterdata/indexpraktikum');
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
        return redirect('/masterdata/indexpraktikum');
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


}
