<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bahan = Bahan::all();
        return view ('inventory.bahan.index', compact('bahan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasi = Lokasi::all();
        return view ('inventory.bahan.create', compact('lokasi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $bahan =  $request->validate([
            'nama_bahan' => 'required|max:255',
            'rumus_kimia' => 'required',
            'jumlah' => 'required|integer',
            'lokasi_id' => 'required',
       ]);

       $bahan = new Bahan();
       $bahan->nama_bahan = $request->nama_bahan;
       $bahan->rumus = $request->rumus_kimia;
       $bahan->jumlah = $request->jumlah;
       $bahan->lokasi_id = $request->lokasi_id;

       $bahan->save();

       return redirect('/inventory/bahan')->with('success', 'Data Bahan berhasil ditambahkan');
    }

    public function exportbahan()
    {
        $bahan = Bahan::all();
        $pdf = Pdf::loadView('pdf.exportbahan', compact ('bahan'));
        return $pdf->stream();
    }

    public function showedit($id_bahan)
    {
        $lokasi = Lokasi::all();
        $data = Bahan::find($id_bahan);
        return view ('inventory.bahan.edit', compact('data', 'lokasi'));
    }

    public function storeedit(Request $request, $id_bahan)
    {

        //dd($request);
        $data = Bahan::find($id_bahan);
        $data->update($request->all());


        return redirect('/inventory/bahan')->with('success', 'Data Bahan berhasil diubah');
    }
}
