import React from 'react';
import { Table } from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.js';

const UltimaNomina = ({ nomina }) => {
  return (
    <>
      <h1>Última Nómina</h1>
      <div className="table-responsive">
        <Table bordered className="rounded">
          <thead>
            <tr>
              <th>Mes y Año</th>
              <th>Salario Base</th>
              <th>Salario Bruto</th>
              <th>IRPF</th>
              <th>Complementos</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{nomina.month !== "" ? nomina.month + ', del ' + nomina.year : ""}</td>
              <td>{nomina.base_salary}</td>
              <td>{nomina.gross_salary}</td>
              <td>{nomina.income_tax !== "" ? nomina.income_tax + '%' : ""}</td>
              <td>{nomina.concept}</td>
            </tr>
          </tbody>
        </Table>
      </div>
    </>
  );
};

export default UltimaNomina;
