<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Illuminate\Http\Response;


class PayrollController extends Controller
{
    public function generatePdf()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('<h1>Hello, World!</h1><p>This is your payroll</p>');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"'
        ]);
    }

    public function downloadPdf()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('<h1>Hello, World!</h1><p>This is your payroll</p>');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Nómina.pdf'); //metodo stream permite descargarlo

    }
}
