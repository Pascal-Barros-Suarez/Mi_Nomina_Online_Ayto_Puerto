<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\User;

use Inertia\Inertia;
use Dompdf\Dompdf;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;



class PayrollController extends Controller
{
  public function userPayrolls()
  {
    $payrolls = User::where('id', Auth::id())
      ->with('payroll')
      //->latest()
      ->get();

    return dd($payrolls);
  }

  public function lastPayroll()
  {
    $lastPayroll = User::where('id', Auth::id())
      ->with(['payroll' => function ($query) { //dentro de nominas ordenar por:
        $query->orderBy('year', 'desc') // Ordenar las nóminas por año de forma descendente
          ->orderBy('month', 'desc'); // Luego ordenar las nóminas por mes de forma descendente
      }])
      ->firstOrFail() //Obtener el usuario o lanzar una excepción si no se encuentra
      ->payroll //accedemos a la variable
      ->first(); //recoger solo la ultima nomina

    if (empty($lastPayroll)) {
      Session::flash('error', 'no tiene nomina!');
      $array = array(
        "month" => "",
        "year" => "",
        "base_salary" => "",
        "gross_salary" => "",
        "income_tax" => "",
        "concept" => ""
      );
      return Inertia::render('Dashboard',  ['payroll' => $array]);
    } else {
      $array = $lastPayroll->getAttributes();
      return Inertia::render('Dashboard',  ['payroll' => $array]);
    }
  }

  public function generatePdf(Request $request)
  {
    //recoger datos
    $month = intval($request->input('month'));
    $year = intval($request->input('year'));


    // Consulta de datos para el PDF
    $user = User::where('id', Auth::id())
      ->with(['payroll' => function ($query) use ($month, $year) {
        $query->where('month', $month)
          ->where('year', $year);
      }])
      ->first();

    // Verificar si se encontró el usuario y la nómina
    if (!$user) {
      // Manejar el caso de que no se encuentre el usuario o la nómina
      // Puedes retornar un mensaje de error, lanzar una excepción, etc.
      return response()->json(['error' => 'Usuario o nómina no encontrados'], 404);
    } else {

      //require_once('/app/templates/pdf-template.php'); // Importa el archivo pdf-template.php

      //contenido del pdf
      $bootstrapJS = file_get_contents(public_path('css/bootstrap/bootstrap.min.js'));
      $bootstrapCCS = file_get_contents(public_path('css/bootstrap/bootstrap.min.css'));
      $customCSS = file_get_contents(public_path('css/custom.css'));
      //$customHTML = file_get_contents(public_path('html/template.html'));

      //datos del usuario
      $userData = $user->getAttributes();

      //datos de la empresa
      $companiData = Config::get('compani.COMPANI_FIELDS');

      //datos de la nomina
      $payrollData = $user->payroll->first();
      if (empty($payrollData)) {
        //Session::flash('error', 'No tiene nomina de el mes seleccionado!');
        // Lanzar una excepción o retornar un mensaje de error
        throw new \Exception('No tiene nómina para el mes seleccionado');
      } else {
        $payrollData = $payrollData->getAttributes();

        switch ($payrollData["month"]) {
          case 1:
            $month = "Enero";
            break;
          case 2:
            $month = "Febrero";
            break;
          case 3:
            $month = "Marzo";
            break;
          case 4:
            $month = "Abril";
            break;
          case 5:
            $month = "Mayo";
            break;
          case 6:
            $month = "Junio";
            break;
          case 7:
            $month = "Julio";
            break;
          case 8:
            $month = "Agosto";
            break;
          case 9:
            $month = "Septiembre";
            break;
          case 10:
            $month = "Octubre";
            break;
          case 11:
            $month = "Noviembre";
            break;
          case 12:
            $month = "Diciembre";
            break;
          default:
            // Asigna un valor por defecto si el valor de month no se encuentra en el rango 1-12
            $month = "Mes desconocido";
            break;
        }
        $totalDeducciones = $payrollData['commission_attendance']
          + $payrollData['unemployment']
          + $payrollData['mei']
          + $payrollData['professional_training'];

        $irpfResolved  =  $payrollData['gross_salary'] * ($payrollData['income_tax'] / 100);

        $totalOtrasDeducciones = $irpfResolved
          + $payrollData['csic'];

        $html = '<html>
            <head>
            <meta charset="UTF-8">
                <style>
                '  . $bootstrapCCS . '
                '  . $bootstrapJS . '
                    ' . $customCSS . '
                </style>
            </head>
            <body>
            <div class="container">
              <h1>Nómina de ' . $month . ', del ' . $payrollData["year"] . '</h1>
              <hr />
              <div class="row">
                <div class="col-md-6 tbc-123">
                  <h2>Datos personales</h2>
                  <table class="table">
                    <tbody>
                      <tr>
                        <td><strong>Nombre:</strong></td>
                        <td>' . $userData["name"] . '</td>
                      </tr>
                      <tr>
                        <td><strong>DNI:</strong></td>
                        <td>' . $userData['dni'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>Número de seguridad social:</strong></td>
                        <td>' . $userData['social_security_number'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>Departamento:</strong></td>
                        <td>' . $userData['department'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>Posición/Cargo:</strong></td>
                        <td>' . $userData['position'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>Fecha de contratación:</strong></td>
                        <td>' . $userData['hiring_date'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>Grupo:</strong></td>
                        <td>' . $userData['group'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>Nivel:</strong></td>
                        <td>' . $userData['level'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>CNAE 93:</strong></td>
                        <td>' . $userData['cnae_93'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>Grupo de cotización:</strong></td>
                        <td>' . $userData['contribution_group'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>Tipo:</strong></td>
                        <td>' . $userData['type'] . '</td>
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
                        <td>' . $companiData['nombre'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>Domicilio:</strong></td>
                        <td>' . $companiData['domicilio'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>CIF:</strong></td>
                        <td>' . $companiData['cif'] . '</td>
                      </tr>
                      <tr>
                        <td><strong>Cuenta de cotización:</strong></td>
                        <td>' . $companiData['cuenta_de_cotizacion'] . '</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-md-12">
                  <h2>Detalles de la nómina</h2>
                  <br/>
                  <h4 class="mb-5">DEVENGOS </h4>

                  <table class="table">
                    <thead>
                      <tr>
                        <th>Concepto</th>
                        <th>Importe</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>Sueldo bruto</td>
                      <td>' . $payrollData['gross_salary'] . '€</td>
                    </tr>
                    <tr>
                    <td>Sueldo base</td>
                    <td>' . $payrollData['base_salary'] . '€</td>
                    </tr>
                    
                    <tr>
                      <tr>
                        <td>Complemento destino</td>
                        <td>' . $payrollData['destination_allowance'] . '€</td>
                      </tr>
                      <tr>
                        <td>Complemento específico</td>
                        <td>' . $payrollData['specific_allowance'] . '€</td>
                      </tr>
                      <tr>
                        <td>Asistencia a comisiones</td>
                        <td>' . $payrollData['commission_attendance'] . '€</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <h2>Deducciones</h2>
                  <table class="table">
                  <br/>
                  <h4 class="mb-5">Aportaciones del trabajador a las cotizaciones de la seguridad social </h4>
                    <thead>
                      <tr>
                        <th>Concepto</th>
                        <th>Importe</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Contingencias comunes</td>
                        <td>-' . $payrollData['commission_attendance'] . '€</td>
                      </tr>
                      <tr>
                        <td>Desempleo</td>
                        <td>-' . $payrollData['unemployment'] . '€</td>
                      </tr>
                      <tr>
                        <td>MEI</td>
                        <td>-' . $payrollData['mei'] . '€</td>
                      </tr>
                      <tr>
                        <td>Formación Profesional</td>
                        <td>-' . $payrollData['professional_training'] . '€</td>
                      </tr>
                      <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>-' . $totalDeducciones . '€</strong></td>
                      </tr>
                      <br/>
                      <h4>Otras deducciones </h4>  

                      <tr>
                        <td>Cuota sindicato Intersindical Canaria</td>
                        <td>' . $payrollData['csic'] . '€</td>
                      </tr>                      <tr>
                        <td>IRPF</td>
                        <td>' . $payrollData['income_tax'] . '%</td>
                      </tr>
                      <tr>
                        <td>IRPF calculado</td>
                        <td>' . $irpfResolved . '€</td>
                      </tr>
                      <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>-' . $totalOtrasDeducciones . '€</strong></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              </div>
    
            </body>
        </html>';



        //creaccion del pdf
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        //$options->setDebugCss(true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html); // Usa la variable $html del archivo pdf-template.php
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();

        return new Response($pdfContent, 200, [
          'Content-Type' => 'application/pdf',
          'Content-Disposition' => 'inline; filename="nomina.pdf"'
        ]);
      }
    }
  }
}
