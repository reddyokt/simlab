<?php

namespace App\Http\Controllers;

use App\Models\Daftar;
use App\Models\Mahasiswa;
use App\Models\Praktikum;
use Illuminate\Bus\UpdatedBatchJobCounts;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function daftar()
    {
        $daftar = DB::table('mahasiswa')
        ->get();
        $kelas = DB::table('praktikum')
        ->get();

       // $data = Mahasiswa::all();
        //$kelas = Praktikum::all();
        return view('daftar.daftarPraktikum', compact('daftar','kelas'));

    }
    public function findNim(Request $request){
        $data=Mahasiswa::select('nim','id_mahasiswa')->where('nim', $request->id_mahasiswa)->take(100)->get();
        return response()->json($data);
    }
    public function findnamamhs(Request $request){
        $m=Mahasiswa::select('nama_mahasiswa')->where('id_mahasiswa', $request->id_mahasiswa)->first();
        return response ()->json($m);
    }

    public function store(Request $request)
    {

        //return $request;
            $pendaftaran =  $request->validate([
            'id_mahasiswa' => 'required',
            'namamhs'=>'required',
            'phone' => 'required|numeric|min:10',
            'email'=> 'required|email:dns|unique:pendaftaran',
            'id_kelas'=>'required'
   ]);

        $pendaftaran = new Daftar();
        $pendaftaran->mahasiswa_id = $request->id_mahasiswa;
        $pendaftaran->created_by = $request->namamhs;
        $pendaftaran->email= $request->email;
        $pendaftaran->phone= $request->phone;
        $pendaftaran->kelas_id=$request->id_kelas;

        $pendaftaran->save();

        // $mahasiswa = Mahasiswa::all();


        // Mail::raw('Selamat' .$mahasiswa->nama_mahasiswa, 'Pendaftaran Kelas Praktikum anda telah berhasil', function ($message) use($pendaftaran) {

        //     $message->to($pendaftaran->email, 'John Doe');
        //     $message->subject('Pendaftaran Kelas Praktikum anda berhasil');

        // });

        return redirect('/daftarPraktikum')->with('success', 'Pendaftaran berhasil');
    }

    public function setuju(Request $request, $id_pendaftaran)
    {

        $pendaftaran = Daftar::find($id_pendaftaran);
        $pendaftaran->update($request->all());

        return redirect ('/dashboard')->with('success', 'Data Praktikan diubah');
    }
}
