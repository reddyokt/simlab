<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('dosen.index', [
            'dosens'=>Dosen::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('dosen.create');
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
        $user = User::create([
            'username' => $request->nidn,
            'nama_lengkap' => $request->nama_lengkap,
            'role_id' => $request->role_id,
            'password' => Hash::make('qwerty')
        ]);


        $dosen = Dosen::create([
            'user_id' => $user->id,
            'nidn'=> $request->nidn,
            'nama_dosen'=> $request->nama_lengkap

        ]);
        return redirect ('/dosen')->with('success', 'Data Dosen berhasil ditambahkan');


    }
    //     $validatedData =  $request->validate([
    //         'nama_lengkap' => 'required|max:50',
    //         'nidn' => 'required|unique:dosen',
    //    ]);
    //    Dosen::create($validatedData);
    //    return redirect ('/dosen')->with('success', 'Data Dosen berhasil ditambahkan');
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dosen = Dosen::find($id);
        return view('dosen.edit', compact('dosen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $dosen = Dosen::find($id);
        $dosen->update($request->all());

        return redirect ('/dosen')->with('success', 'Data Dosen berhasil diubah');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dosen $dosen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $dosen = Dosen::find($id);
        $dosen->delete();

        return redirect ('/dosen')->with('success', 'Data Dosen berhasil dihapus');
    }
}
