<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;

class PayrollController extends Controller
{
    public function generatePdf()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('<h1>Hello, World!</h1>');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('document.pdf');
    }
}
