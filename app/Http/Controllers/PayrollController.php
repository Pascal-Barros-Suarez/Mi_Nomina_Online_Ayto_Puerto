<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\User;

use Dompdf\Dompdf;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;



class PayrollController extends Controller
{
  public function UserPayrolls()
  {
    $payrolls = User::where('id', Auth::id())
      ->with('payroll')
      ->latest()
      ->get();

    return dd($payrolls);
  }



  public function generatePdf()
  {
    //datos para el pdf
    
    //$user = Auth::user();
    $payroll = User::where('id', Auth::id())
    ->with('payroll')
    ->latest()
    ->get();
    
    require_once('/app/templates/pdf-template.php'); // Importa el archivo pdf-template.php
    
    //creaccion del pdf
    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    //$options->setDebugCss(true);

    $dompdf->setOptions($options);
    $dompdf->loadHtml($html); // Usa la variable $html del archivo pdf-template.php
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $pdfContent = $dompdf->output();

    Session::flash('success', 'Generating PDF!');

    return new Response($pdfContent, 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'inline; filename="Nómina.pdf"'
    ]);
  }
}
