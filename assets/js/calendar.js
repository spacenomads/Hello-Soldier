import {newElement} from './dom.js';

function getTotalDays(year) {
  return isLeapYear(year) ? 366 : 365;
}


function dateFromDay(year, day){
  const date = new Date(year, 0);
  const doyDate = new Date(date.setDate(day));
  return doyDate.toLocaleDateString('en-US');
}

function isLeapYear(year) {
  if ((year & 3) != 0) return false;
  return ((year % 100) != 0 || (year % 400) == 0);
};



function createCalendar(year, container) {
  console.log(year, isLeapYear(year));
  const days = getTotalDays(year);

  const calendar = newElement('ul', 'calendar');
  for (let d=1; d<=days; d++) {
    const calendarItem = newElement('li', 'calendar__day calendar__day--' + d, dateFromDay(year, d))
    calendar.appendChild(calendarItem);
  }
  container.appendChild(calendar);
}




export {createCalendar};