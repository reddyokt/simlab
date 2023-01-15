<?php

namespace App\Http\Controllers;

use App\Models\Landing;
use App\Models\Modul;
use App\Models\Pengumuman;
use App\Models\Praktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Praktikum::all();
        $now = Carbon::now()->toDateString();
        //$jadwal = Modul::where('is_active','YA')
        $jadwal = DB::table('tugas')
        ->join('modul', 'modul.id_modul', '=' , 'tugas.modul_id')
        ->join('praktikum', 'praktikum.id_praktikum', '=', 'modul.kelas_id')
        ->join('dosen', 'dosen.id_dosen', '=' , 'praktikum.dosen_id' )
        ->leftJoin('kelas', 'kelas.id_kelas', '=' ,'praktikum.kelas_id')
        //->leftJoin('tugas', 'tugas.modul_id', '=' ,'modul.id_modul')
        ->wherein('tugas.is_active',['Y'])
        ->get();


           // $jadwal['tanggal_praktek'] = $this->changeFormat(['tanggal_praktek'], true);


        return view ('landing.layouts.main',compact('jadwal','kelas'));
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

    public function pengumuman()
    {
        return view ('landing.indexpengumuman');
    }

    public function createpengumuman()
    {
        return view ('landing.createpengumuman');
    }

    public function storepengumuman(Request $request)
    {
       // ddd($request);

        $validatedData = $request->validate([
            'judul_pengumuman'=> 'required|max:255',
            'uraian_pengumuman'=> 'required',
            'image'=> 'image|file|max:2048'
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('gambar_pengumuman');
        }

        Pengumuman::create($validatedData);

        return redirect ('/pengumuman');
    }

}
