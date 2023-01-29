<?php

namespace App\Http\Controllers;

use App\Models\Membermodul;
use App\Models\Modul;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
   public function transaksi()
   {
    $data = Modul::whereHas('catatan')
    ->where('used','!=','0')
    ->get();

    //dd($data->toArray());
    return view('inventory.transaksi', compact ('data'));
   }

   public function exporttransaksi()
   {
    $data = Modul::whereHas('catatan')
    ->where('used','!=','0')
    ->get();

    $pdf = Pdf::loadView('pdf.exporttransaksi', compact ('data'));
    return $pdf->stream();
   }
}
