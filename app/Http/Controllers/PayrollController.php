<?php

namespace App\Http\Controllers;

use App\Models\User;

use Dompdf\Dompdf;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;



class PayrollController extends Controller
{
    public function allPayrolls()
    {
    }



    public function generatePdf()
    {
        Session::flash('success', 'Generating PDF!');

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();

        $dompdf->setOptions($options);
        $dompdf->loadHtml('<h1>Hello, World!</h1>
        <p>This is your payroll</p>
        <p>This is your payroll</p>
        <p>This is your payroll</p>
        <p>This is your payroll</p>
        <p>This is your payroll</p>
        <p>This is your payroll</p>
        <p>This is your payroll</p>
        <p>This is your payroll</p>
        <p>This is your payroll</p>
        <p>This is your payroll</p>
        <p>This is your payroll</p>
        <p>This is your payroll</p>
        ');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"'
        ]);
    }
}
