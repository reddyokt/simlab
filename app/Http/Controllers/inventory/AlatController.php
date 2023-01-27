<?php

namespace App\Http\Controllers\inventory;

use App\Models\Alat;
use App\Models\Lemari;
use App\Models\Lokasi;
use App\Models\c2a_alat;
use App\Models\c2b_alat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlatController extends Controller
{
    public function index()

    {

        $c2a_alat=c2a_alat::all();
        $c2b_alat=c2b_alat::all();
        return view ('inventory.alat.index', compact('c2a_alat','c2b_alat'));
    }

    public function createlemari()
    {

            $lemari=Lemari::all();
            $location=Lokasi::all();
            return view ('inventory.alat.lemari', compact('lemari','location'));
    }

    public function storelemari(Request $request)
    {
            //return $request;
        $validatedData =  $request->validate([
            'nama_lemari' => 'required|max:50',
            'lokasi_id'=>'required'

       ]);

       Lemari::create($validatedData);
       return Redirect()->back()->with('success', 'Data Lemari berhasil ditambahkan');

    }

    public function storelokasi(Request $request)
    {
        //return $request;
        $validatedData =  $request->validate([
            'nama_lokasi' => 'required|max:50'
       ]);

       Lokasi::create($validatedData);

       return Redirect()->back()->with('success', 'Data Lokasi berhasil ditambahkan');

    }
    //---------------------------------------------------c2a---------------------------------------//

    public function createalatc2a()
    {
        $lemaris = Lemari::all();
        return view ('inventory.alat.createalatc2a', compact('lemaris'));
    }


    public function storealatc2a(Request $request)
    {
        //return $request;
        $validatedData =  $request->validate([
            'nama_alat_c2a' => 'required|max:255',
            'merk' => 'required|max:255',
            'jumlah' => 'required|max:255',
            'rusak' => 'required',
            'lemari_id' => 'required',
            'baris' => 'required|numeric|min:1',
            'kolom' => 'required|numeric|min:1'
        ]);

        c2a_alat::create($validatedData);

        return  redirect('/inventory/alat')->with('success', 'Data Alat C2A berhasil ditambahkan');
    }

    public function showc2a($id_alat_c2a)
    {
        $c2a_alat = c2a_alat::find($id_alat_c2a);
        $lemaris =Lemari::all();
        return view('inventory.alat.editalatc2a', compact('c2a_alat','lemaris'));
    }

    public function editalatc2a(Request $request, $id_alat_c2a)
    {
        $c2a_alat = c2a_alat::find($id_alat_c2a);
        $c2a_alat->update($request->all());

        return redirect ('/inventory/alat')->with('success', 'Data Alat C2A berhasil diubah');
    }

    public function deletec2a($id_alat_c2a)
    {
        $c2a_alat = c2a_alat::find($id_alat_c2a);
        $c2a_alat->delete();

        return redirect ('/inventory/alat')->with('success', 'Data Alat C2A berhasil dihapus');
    }
    //-------------------------------------------c2b--------------------------------------//

    public function createalatc2b()
    {
        $lokasi = Lokasi::all();
        return view ('inventory.alat.createalatc2b', compact('lokasi'));
    }

    public function storealatc2b(Request $request)
    {
        //return $request;
        $validatedData =  $request->validate([
            'nama_alat_c2b' => 'required|max:255',
            'merk' => 'required',
            'ukuran' => 'required',
            'pabrikan' => '',
            'jumlah' => 'required|integer|min:1',
            'rusak' => 'required',
            'lokasi_id' => 'required'
        ]);

        c2b_alat::create($validatedData);
        return redirect ('/inventory/alat')->with('success', 'Data Alat C2B berhasil ditambahkan');
    }

    public function showc2b($id_alat)
    {
        $c2b_alat = c2b_alat::find($id_alat);
        $lokasi =Lokasi::all();
        return view('inventory.alat.editalatc2b', compact('c2b_alat','lokasi'));
    }

    public function editalatc2b(Request $request, $id_alat)
    {
        $c2b_alat = c2b_alat::find($id_alat);
        $c2b_alat->update($request->all());

        return redirect ('/inventory/alat')->with('success', 'Data Alat C2B berhasil diubah');
    }

    public function deletec2b($id_alat)
    {
        $c2b_alat = c2b_alat::find($id_alat);
        $c2b_alat->delete();

        return redirect ('/inventory/alat')->with('success', 'Data Alat C2B berhasil dihapus');
    }
}
