import React, { useState, useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import { Form } from 'react-bootstrap';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';
import { registerLocale } from 'react-datepicker'; // Importar la función registerLocale para registrar el localizador
import es from 'date-fns/locale/es'; // Importar el localizador en español

registerLocale('es', es); // Registrar el localizador en español

const Calendar = ({ onMonthChange, onYearChange }) => {
  const { auth } = usePage().props; //parametros pasados por inertia
  const [selectedDate, setSelectedDate] = useState(new Date());

  useEffect(() => {
    if (onMonthChange) {
      const month = selectedDate.getMonth() + 1;
      onMonthChange(month);
    }

    if (onYearChange) {
      const year = selectedDate.getFullYear();
      onYearChange(year);
    }
  }, []);

  const handleDateChange = (date) => {
    const currentDate = new Date(); // Obtener la fecha actual
    const hiringDate = new Date(auth.user.hiring_date); // Obtener la fecha de contratación del usuario autenticado
    hiringDate.setDate(1); // Establecer el día en 1 para comparar solo mes y año

    if (date > currentDate || date < hiringDate) {
      return; // Ignorar la selección de una fecha fuera del rango permitido
    } else {
      setSelectedDate(date);
    }


    if (onMonthChange) {
      const month = date.getMonth() + 1;
      onMonthChange(month);
    }

    if (onYearChange) {
      const year = date.getFullYear();
      onYearChange(year);
    }
  };

  return (
    <div>
      <Form.Group controlId="formCalendar">
        <Form.Label>Selecciona una fecha:</Form.Label>
        <DatePicker
          selected={selectedDate}
          onChange={handleDateChange}
          dateFormat="MM/yyyy"
          showMonthYearPicker
          className="form-control"
          locale="es"
          maxDate={new Date()} // Limitar la fecha máxima al día de hoy
          minDate={new Date(auth.user.hiring_date)} // Limitar la fecha mínima al valor de hiring_date del usuario autenticado
        />
      </Form.Group>
    </div>
  );
};

export default Calendar;
