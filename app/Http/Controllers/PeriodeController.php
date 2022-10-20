<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Faker\Provider\ar_EG\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('periode.index', [
            'periode'=>Periode::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createperiode()
    {
        $periodes = Periode::all();
        return view ('periode.create', compact('periodes'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeperiode(Request $request)
    {
        //return $request;
        $periode =  $request->validate([
            'semester' => 'required',
            'tahun_ajaran'=>'required',
            'startdate' => 'required|date',
            'enddate' => 'required|date'
       ]);
       $periode = new Periode();
       $periode->tahun_ajaran= $request->tahun_ajaran;
       $periode->semester= $request->semester;
       $periode->start_periode = $request->startdate;
       $periode->end_periode = $request->enddate;
       $periode->save();

        return redirect ('/periode')->with('success', 'Data Periode berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function show(Periode $periode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function edit(Periode $periode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Periode $periode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Periode $periode)
    {
        //
    }
}
