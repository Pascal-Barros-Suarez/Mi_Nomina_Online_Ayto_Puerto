import React, { useState } from 'react';

const Calendar = () => {
  const [selectedDate, setSelectedDate] = useState(new Date());

  const handleDateChange = (event) => {
    const { value } = event.target;
    const [selectedYear, selectedMonth] = value.split('-');
    const newDate = new Date(selectedYear, selectedMonth - 1);
    setSelectedDate(newDate);
  };

  const formatDate = (date) => {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    return `${year}-${month}`;
  };

  const renderCalendar = () => {
    const year = selectedDate.getFullYear();
    const month = selectedDate.getMonth();
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();

    const days = [];
    for (let i = 1; i <= daysInMonth; i++) {
      days.push(i);
    }

    return (
      <div>
        <div>
          <select value={formatDate(selectedDate)} onChange={handleDateChange}>
            <option value="2021-01">January 2021</option>
            <option value="2021-02">February 2021</option>
            <option value="2021-03">March 2021</option>
            {/* ... Rest of the months */}
            <option value="2023-05">May 2023</option>
          </select>
        </div>
        <table>
          <thead>
            <tr>
              <th>Sun</th>
              <th>Mon</th>
              <th>Tue</th>
              <th>Wed</th>
              <th>Thu</th>
              <th>Fri</th>
              <th>Sat</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              {Array(firstDay.getDay())
                .fill('')
                .map((_, index) => (
                  <td key={`empty-${index}`}></td>
                ))}
              {days.map((day) => (
                <td key={`day-${day}`}>{day}</td>
              ))}
            </tr>
          </tbody>
        </table>
      </div>
    );
  };

  return <div>{renderCalendar()}</div>;
};

export default Calendar;