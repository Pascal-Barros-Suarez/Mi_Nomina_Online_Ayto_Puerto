import React, { useState, useEffect } from 'react';
import { Form } from 'react-bootstrap';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';
import { registerLocale } from 'react-datepicker'; // Importamos la función registerLocale para registrar el localizador
import es from 'date-fns/locale/es'; // Importamos el localizador en español

registerLocale('es', es); // Registramos el localizador en español

const Calendar = ({ onMonthChange, onYearChange }) => {
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
  }, []); // El efecto se ejecuta solo una vez al cargar la página

  const handleDateChange = (date) => {
    setSelectedDate(date);

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
          locale="es" // Establecemos el localizador en español
        />
      </Form.Group>
    </div>
  );
};

export default Calendar;
