<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rombel;

class PdfController extends Controller
{
    //
    public function __invoke(Rombel $record)
    {
        $pdf = \Barryvdh\DomPDF\Facade\pdf::loadView('pdf', ['record' => $record]);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        return $pdf->stream($record->nama_rombongan . '.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $record->nama_rombongan . '.pdf"'
        ]);
    }
}
