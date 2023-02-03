<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Absen;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mahasiswa.index', [
            'mahasiswa'=>Mahasiswa::all()
        ]);
    }

    public function absenmhs()
    {
        $data = Absen::all();
        return view ('mahasiswa.absenmhs', compact ('data'));
    }

    public function nilaimhs()
    {
        $data = Absen::all();
        return view ('mahasiswa.nilaimhs', compact ('data'));
    }
}
