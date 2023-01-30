<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('inventory.barang.index', [
            'barang'=>Barang::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {   $lokasi = Lokasi::all();
        return view ('inventory.barang.create', compact('lokasi'));
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
        $validatedData =  $request->validate([
            'nama_barang' => 'required|max:255',
            'merk_barang' => '',
            'ukuran_barang' => '',
            'pabrik_barang'=>'',
            'jumlah_barang' => 'required|max:255',
            'barang_rusak' => 'required',
            'lokasi_id' => 'required'
        ]);

        Barang::create($validatedData);

        return redirect('/inventory/barang')->with('success', 'Data Barang berhasil ditambahkan');
    }

    public function showbarang($id_barang)
    {
    $barang = Barang::find($id_barang);
    $lokasi = Lokasi::all();
    return view('inventory.barang.edit', compact('barang', 'lokasi'));
    }

    public function editbarang(Request $request, $id_barang)
    {
        //return $request;
        $barang = Barang::find($id_barang);
        $barang->update($request->all());

        return redirect ('/inventory/barang')->with('success', 'Data Barang berhasil diubah');

    }

    public function deletebarang($id_barang)
    {
        $barang = Barang::find($id_barang);
        $barang->delete();

        return redirect ('/inventory/barang')->with('success', 'Data Barang berhasil dihapus');
    }

    public function exportbarang()
    {
        $barang = Barang::all();
        $pdf = Pdf::loadView('pdf.exportbarang', compact ('barang'));
        return $pdf->stream();
    }
}
