import React from 'react';
import { Table } from 'react-bootstrap';

const UltimaNomina = ({ nomina }) => {
  return (
    <><h1>Última Nómina</h1>
      <Table bordered>
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
            {/* <td>{nomina[0].mes}, del {nomina.año}</td> */}
            <td>{nomina}</td>
            <td>{'1'}</td>
            <td>{'1'}</td>
            <td>{'1'}</td>
            <td>{'1'}</td>
            {/* <td>{nomina.salarioBase}</td>
            <td>{nomina.salarioBruto}</td>
            <td>{nomina.irpf}</td>
            <td>{nomina.complementos}</td> */}
          </tr>
        </tbody>
      </Table></>
  );
}

export default UltimaNomina;
