<?php

namespace App\Http\Controllers;

use App\Models\Landing;
use App\Models\Modul;
use App\Models\Pengumuman;
use App\Models\Praktikum;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Download;
use App\Models\JawabanTugas;

class LandingController extends Controller
{

    public function index()
    {
        $pengumuman = DB::table('pengumuman')
        ->get();
        $download = DB::table('download')
        ->get();

        $kelas = Praktikum::all();
        $now = Carbon::now()->toDateString();
        //$jadwal = Modul::where('is_active','YA')
        // $jadwal = DB::table('tugas')
        // ->join('modul', 'modul.id_modul', '=' , 'tugas.modul_id')
        // ->join('praktikum', 'praktikum.id_praktikum', '=', 'modul.praktikum_id')
        // ->join('dosen', 'dosen.id_dosen', '=' , 'praktikum.dosen_id' )
        // ->leftJoin('kelas', 'kelas.id_kelas', '=' ,'praktikum.kelas_id')
        // ->leftJoin('praktikum_mahasiswa','praktikum_mahasiswa.praktikum_id', '=' , 'praktikum.id_praktikum')
        // ->leftJoin('mahasiswa','mahasiswa.id_mahasiswa', '=' ,'praktikum_mahasiswa.mahasiswa_id')
        // //->leftJoin('tugas', 'tugas.modul_id', '=' ,'modul.id_modul')
        // ->wherein('tugas.is_active',['Y'])
        // ->get();

        $data = Modul::whereHas('praktikum',function ($q){
            $q->whereHas('periode', function ($q2){
                $q2->where('status_periode','Aktif');
            });
        }) ->get();
        return view ('landing.layouts.main',compact('data','kelas','pengumuman','download'));
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
        $pengumuman = Pengumuman::all();
        return view ('landing.indexpengumuman', compact('pengumuman'));
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

    public function uploadjawabantugas(Request $request)
    {
        //dd($request->all());

       $validatedData = $request->validate([
            'tugas_id'=>'required',
            'mahasiswa_id'=>'required',
            'dataimport'=>'required|mimes:png,jpg,pdf|max:2048'
        ]);

        if($request->file('dataimport')) {
            $validatedData['file_jawaban'] = $request->file('dataimport')->store('upload_jawaban');
        }
        unset($validatedData['dataimport']);
        JawabanTugas::create($validatedData);

        return redirect ('/');

    }

    public function download()
    {
        $download = Download::all();
        return view ('landing.indexdownload',compact ('download'));
    }

    public function createdownload()
    {
        return view ('landing.createdownload');
    }

    public function storedownload(Request $request)
    {
       //ddd($request->all());

        $validatedData = $request->validate([
            'judul_file'=> 'required|max:255',
            'uraian_file'=> 'required',
            'pdf'=> 'required|mimes:pdf|max:10120'
        ]);

        if($request->file('pdf')) {
            $validatedData['pdf'] = $request->file('pdf')->store('pdf_download');
        }

        Download::create($validatedData);

        return redirect ('/download');
    }
}
