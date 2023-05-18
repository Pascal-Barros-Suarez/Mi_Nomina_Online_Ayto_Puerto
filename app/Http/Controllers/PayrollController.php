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
        $user = Auth::user();
        $payrolls = User::where('id', Auth::id())
            ->with('payroll')
            ->latest()
            ->get();

        //contenido del pdf
        $bootstrapCSS = file_get_contents('/node_modules/bootstrap/dist/js/bootstrap.min.js');
        $customCSS = file_get_contents(public_path('css/custom.css'));
        $html = '
        <html>
            <head>
                <style>
                    ' . $bootstrapCSS . '
                    ' . $customCSS . '
                </style>
            </head>
            <body>
            <div class="container">
            <h1>Nómina</h1>
            <hr />
        
            <div class="row">
                <div class="col-md-6">
                    <h2>Datos personales</h2>
                    <div class="form-group">
                        <label for="nombre y apellidos">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" />
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI:</label>
                        <input type="text" class="form-control" id="dni" />
                    </div>
                    <div class="form-group">
                        <label for="fechaNacimiento">Fecha de nacimiento:</label>
                        <input type="date" class="form-control" id="fechaNacimiento" />
                    </div>
                    <div class="form-group">
                        <label for="seguridadSocial">Número de seguridad social:</label>
                        <input type="text" class="form-control" id="seguridadSocial" />
                    </div>
                    <div class="form-group">
                        <label for="departamento">Departamento:</label>
                        <input type="text" class="form-control" id="departamento" />
                    </div>
                    <div class="form-group">
                        <label for="cargo">Posición/Cargo:</label>
                        <input type="text" class="form-control" id="cargo" />
                    </div>
                    <div class="form-group">
                        <label for="fechaContratacion">Fecha de contratación:</label>
                        <input
                            type="date"
                            class="form-control"
                            id="fechaContratacion"
                        />
                    </div>
                    <div class="form-group">
                        <label for="grupo">Grupo:</label>
                        <input type="text" class="form-control" id="grupo" />
                    </div>
                    <div class="form-group">
                        <label for="nivel">Nivel:</label>
                        <input type="text" class="form-control" id="nivel" />
                    </div>
                    <div class="form-group">
                        <label for="cnae"
                            >CNAE:</label
                        >
                        <input type="text" class="form-control" id="cnae" />
                    </div>
                    <div class="form-group">
                        <label for="grupoCotizacion">Grupo de cotización:</label>
                        <input type="text" class="form-control" id="grupoCotizacion" />
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <input type="text" class="form-control" id="tipo" />
                    </div>
                </div>
                <div class="col-md-5">
                    <h2>Datos de la empresa</h2>
                    <div class="form-group">
                        <label for="nombreEmpresa">Nombre de la empresa:</label>
                        <input type="text" class="form-control" id="nombreEmpresa" />
                    </div>
                    <div class="form-group">
                        <label for="direccion">Domicilio:</label>
                        <input type="text" class="form-control" id="direccion" />
                    </div>
                    <div class="form-group">
                        <label for="cif">CIF:</label>
                        <input type="text" class="form-control" id="cif" />
                    </div>
                    <div class="form-group">
                        <label for="cuentaCotizacion">Cuenta de cotización:</label>
                        <input type="text" class="form-control" id="cuentaCotizacion" />
                    </div>
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
                                <td>
                                    Aportaciones del trabajador a las cotizaciones de la
                                    seguridad social - Contingencias comunes
                                </td>
                                <td>-50€</td>
                            </tr>
                            <tr>
                                <td>
                                    Aportaciones del trabajador a las cotizaciones de la
                                    seguridad social - Desempleo
                                </td>
                                <td>-20€</td>
                            </tr>
                            <tr>
                                <td>
                                    Aportaciones del trabajador a las cotizaciones de la
                                    seguridad social - MEI
                                </td>
                                <td>-10€</td>
                            </tr>
                            <tr>
                                <td>
                                    Aportaciones del trabajador a las cotizaciones de la
                                    seguridad social - Formación Profesional
                                </td>
                                <td>-30€</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>-110€</td>
                            </tr>
                            <tr>
                                <td>Otras deducciones - IRPF</td>
                                <td>-100€</td>
                            </tr>
                            <tr>
                                <td>
                                    Otras deducciones - Cuota sindicato Intersindical
                                    Canaria
                                </td>
                                <td>-20€</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>-120€</td>
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

        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
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
