import React, { useState, useEffect } from 'react';
import { Form } from 'react-bootstrap';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';

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
  }, []); // El segundo argumento vacío [] indica que se ejecutará solo una vez, al cargar la página

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
        <Form.Label className=' h5'>Selecciona una fecha:</Form.Label>
        <DatePicker
          selected={selectedDate}
          onChange={handleDateChange}
          dateFormat="MM/yyyy"
          showMonthYearPicker
          className="form-control"
        />
      </Form.Group>
    </div>
  );
};

export default Calendar;
