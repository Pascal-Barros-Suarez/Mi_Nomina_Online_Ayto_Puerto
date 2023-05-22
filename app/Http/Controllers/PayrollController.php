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
  public function userPayrolls()
  {
    $payrolls = User::where('id', Auth::id())
      ->with('payroll')
      ->get();

    dd($payrolls);
  }


  public function lastPayroll()
  {
    // Obtener el usuario autenticado actualmente
    $lastPayroll = User::where('id', Auth::id())
      ->with(['payroll' => function ($query) {
        $query->orderBy('year', 'desc') // Ordenar las nóminas por año de forma descendente
          ->orderBy('month', 'desc'); // Luego ordenar las nóminas por mes de forma descendente
      }])
      ->firstOrFail() // Obtener el usuario o lanzar una excepción si no se encuentra
      ->payroll //accedemos a la variable
      ->first(); // Obtener la última nómina del usuario autenticado

    //return $lastPayroll; 
    // Devolver la última nómina
    return Inertia::render('Nomina', [
      'lastPayroll' => $lastPayroll, // Pasar la variable a la plantilla de Inertia
    ]);
  }




  public function generatePdf()
  {
    //datos para el pdf
    $payroll = User::where('id', Auth::id())
      ->with('payroll')
      ->latest()
      ->get();

    //require_once('/public/templates/pdf-template.php'); // Importa el archivo pdf-template.php

    //creaccion del pdf
    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    //$options->setDebugCss(true);
    //contenido del pdf

    $bootstrapJS = file_get_contents(public_path('css/bootstrap/bootstrap.min.js'));
    $bootstrapCCS = file_get_contents(public_path('css/bootstrap/bootstrap.min.css'));
    $customCSS = file_get_contents(public_path('css/custom.css'));

    $html = '
        <html>
            <head>
                <style>
                '  . $bootstrapCCS . '
                '  . $bootstrapJS . '
                    ' . $customCSS . '
                </style>
            </head>
            <body>
            <div class="container">
              <h1>Nómina</h1>
              <hr />
              <div class="row">
                <div class="col-md-6 tbc-123">
                  <h2>Datos personales</h2>
                  <table class="table">
                    <tbody>
                      <tr>
                        <td><strong>Nombre:</strong></td>
                        <td>' . $payroll[0]->name . '</td>
                      </tr>
                      <tr>
                        <td><strong>DNI:</strong></td>
                        <td>' . $payroll[0]->dni . '</td>
                      </tr>
                      <tr>
                        <td><strong>Número de seguridad social:</strong></td>
                        <td>' . $payroll[0]->social_security_number . '</td>
                      </tr>
                      <tr>
                        <td><strong>Departamento:</strong></td>
                        <td>' . $payroll[0]->department . '</td>
                      </tr>
                      <tr>
                        <td><strong>Posición/Cargo:</strong></td>
                        <td>' . $payroll[0]->position . '</td>
                      </tr>
                      <tr>
                        <td><strong>Fecha de contratación:</strong></td>
                        <td>' . $payroll[0]->hiring_date . '</td>
                      </tr>
                      <tr>
                        <td><strong>Grupo:</strong></td>
                        <td>' . $payroll[0]->group . '</td>
                      </tr>
                      <tr>
                        <td><strong>Nivel:</strong></td>
                        <td>' . $payroll[0]->level . '</td>
                      </tr>
                      <tr>
                        <td><strong>CNAE 93:</strong></td>
                        <td>' . $payroll[0]->cnae_93 . '</td>
                      </tr>
                      <tr>
                        <td><strong>Grupo de cotización:</strong></td>
                        <td>' . $payroll[0]->contribution_group . '</td>
                      </tr>
                      <tr>
                        <td><strong>Tipo:</strong></td>
                        <td>' . $payroll[0]->type . '</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-5">
                  <h2>Datos de la empresa</h2>
                  <table class="table">
                    <tbody>
                      <tr>
                        <td><strong>Nombre de la empresa:</strong></td>
                        <td>Empresa XYZ</td>
                      </tr>
                      <tr>
                        <td><strong>Domicilio:</strong></td>
                        <td>Calle Principal 123</td>
                      </tr>
                      <tr>
                        <td><strong>CIF:</strong></td>
                        <td>ABC123456789</td>
                      </tr>
                      <tr>
                        <td><strong>Cuenta de cotización:</strong></td>
                        <td>1234567890</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-md-12">
                  <h2>Detalles de la nómina</h2>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Concepto</th>
                        <th>Importe</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Sueldo base</td>
                        <td>1000€</td>
                      </tr>
                      <tr>
                        <td>Complemento destino</td>
                        <td>200€</td>
                      </tr>
                      <tr>
                        <td>Residencia</td>
                        <td>50€</td>
                      </tr>
                      <tr>
                        <td>Complemento específico</td>
                        <td>100€</td>
                      </tr>
                      <tr>
                        <td>Asistencia a comisiones</td>
                        <td>50€</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <h2>Deducciones</h2>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Concepto</th>
                        <th>Importe</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Aportaciones del trabajador a las cotizaciones de la seguridad social - Contingencias comunes</td>
                        <td>-50€</td>
                      </tr>
                      <tr>
                        <td>Aportaciones del trabajador a las cotizaciones de la seguridad social - Desempleo</td>
                        <td>-20€</td>
                      </tr>
                      <tr>
                        <td>Aportaciones del trabajador a las cotizaciones de la seguridad social - MEI</td>
                        <td>-10€</td>
                      </tr>
                      <tr>
                        <td>Aportaciones del trabajador a las cotizaciones de la seguridad social - Formación Profesional</td>
                        <td>-30€</td>
                      </tr>
                      <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>-110€</strong></td>
                      </tr>
                      <tr>
                        <td>Otras deducciones - IRPF</td>
                        <td>-100€</td>
                      </tr>
                      <tr>
                        <td>Otras deducciones - Cuota sindicato Intersindical Canaria</td>
                        <td>-20€</td>
                      </tr>
                      <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>-120€</strong></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              </div>
    
            </body>
        </html>';
    $dompdf->setOptions($options);
    $dompdf->loadHtml($html); // Usa la variable $html del archivo pdf-template.php
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $pdfContent = $dompdf->output();

    Session::flash('success', 'Generating PDF!');

    // Retornar la respuesta a Inertia con el PDF en base64
    /* return Inertia::render('Nomina')->with([
      'pdfContent' => $pdfContent,
      'filename' => 'Nómina.pdf',
    ]); */

    return new Response($pdfContent, 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'inline; filename="Nómina.pdf"'
    ]);
  }
}
