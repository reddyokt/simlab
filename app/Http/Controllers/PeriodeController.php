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

    public function showperiode($id)
    {
        //dd($id);
        $periode = Periode::find($id);
        //dd($periode);
        return view ('periode.edit', compact('periode'));
    }


    public function editperiode(Request $request, $id)
    {
        //dd($request->all());
        $periode = Periode::find($id);
        $periode->update($request->all());

        return redirect ('/periode')->with('success', 'Data Periode berhasil diubah');
    }

    function changeFormat($date, $reverse = false){
        $format = null;
        if($reverse){
            $arr_month = [
                '01'=>'January',
                '02'=>'February',
                '03'=>'March',
                '04'=>'April',
                '05'=>'May',
                '06'=>'June',
                '07'=>'July',
                '08'=>'August',
                '09'=>'September',
                '10'=>'October',
                '11'=>'November',
                '12'=>'December'
            ];

            $exp = explode("-",$date);

            $format = $exp[2].' '.$arr_month[$exp[1]].' '.$exp[0];
        }else{
            $arr_month = [
                'January'=>'01',
                'February'=>'02',
                'March'=>'03',
                'April'=>'04',
                'May'=>'05',
                'June'=>'06',
                'July'=>'07',
                'August'=>'08',
                'September'=>'09',
                'October'=>'10',
                'November'=>'11',
                'December'=>'12'
            ];

            $exp = explode(" ",$date);

            $format = $exp[2].'-'.$arr_month[$exp[1]].'-'.$exp[0];
        }

        return $format;
    }
}
