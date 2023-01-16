<?php

namespace App\Http\Controllers;


use App\Models\Praktikum;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Periode;
use Illuminate\Http\Request;

class PraktikumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('praktikum.index', [
            'praktikums'=>Praktikum::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createkelas()
    {
        $dosens = Dosen::all();
        $periode= Periode::all();
        $kelas=Kelas::all();
        return view ('praktikum.createkelas', compact('dosens','periode','kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storekelas(Request $request)
    {
        //return $request;
        $praktikum =  $request->validate([
            'nama_kelas' => 'required|max:255',
            'periode'=>'required',
            'dosen_id' => 'required',
            'jumlah_modul' => 'required|integer'

       ]);

       $praktikum = new Praktikum;
       $praktikum->kelas_id = $request->nama_kelas;
       $praktikum->periode_id= $request->periode;
       $praktikum->dosen_id= $request->dosen_id;
       $praktikum->jumlah_modul = $request->jumlah_modul;

       $praktikum->save();

        return redirect ('/kelas')->with('success', 'Data Kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Praktikum  $praktikum
     * @return \Illuminate\Http\Response
     */
    public function showkelas($id_praktikum)
    {
        $dosens =Dosen::all();
        $praktikum = Praktikum::find($id_praktikum);
        return view('praktikum.editkelas', compact('praktikum','dosens'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Praktikum  $praktikum
     * @return \Illuminate\Http\Response
     */
    public function editkelas(Request $request, $id_praktikum)
    {
        //dd($request->all());
        $praktikum = Praktikum::find($id_praktikum);
        $praktikum->update($request->all());

        return redirect ('/kelas')->with('success', 'Data Kelas berhasil diubah');
    }


    public function deletekelas($id_praktikum)
    {
        $praktikum = Praktikum::find($id_praktikum);
        $praktikum->delete();

        return redirect ('/kelas')->with('success', 'Data Kelas berhasil dihapus');
    }
}
