<?php

namespace App\Http\Controllers;


use App\Models\Praktikum;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Periode;
use App\Models\User;
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

        $role = auth()->user()->role->role_name;
        //dd($role);
        $praktikums = Praktikum::whereHas('periode', function($q){
            $q->where('status_periode', 'Aktif');
        });

        if($role == 'Kepala Lab')
            $praktikums = $praktikums->get();

        if($role == 'Ka Unit') {
            $dosen = Dosen::where("user_id", auth()->id())->first();
            $praktikums = $praktikums->where("dosen_id", $dosen->id_dosen)->get();
        }

        $aslab = User::where('role_id','4')->get();
        //dd($aslab);


        return view ('praktikum.index', compact ('aslab','praktikums'));
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
        $kelas=Kelas::where('is_active', 'Y')->get();
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
        //dd($request->all());
        $praktikum =  $request->validate([
            'nama_praktikum' => 'required|max:255',
            'periode'=>'required',
            'dosen_id' => 'required',
            'nama_kelas' => 'required|string|max:50'

       ]);

       $praktikum = new Praktikum;
       $praktikum->kelas_id = $request->nama_praktikum;
       $praktikum->periode_id= $request->periode;
       $praktikum->dosen_id= $request->dosen_id;
       $praktikum->nama_kelas= $request->nama_kelas;
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

    public function aslab (Request $request)
    {
        //dd($request->all());
        $praktikum = Praktikum::findOrFail($request->id_praktikum);
        $praktikum->update([
            "asisten_id" => $request->asisten_id
        ]);
        return redirect ('/kelas')->with('success', 'Asisten Lab berhasil ditambahkan');
    }
}
