import {createCalendar} from "./calendar.js";

const CURRENT_YEAR = 2020;
const cal = document.querySelector('.calendar__outer');

createCalendar(CURRENT_YEAR, cal);