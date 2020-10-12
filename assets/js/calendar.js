import {createNewElement} from './dom.js';





function getTotalDays(year) {
	return isLeapYear(year) ? 366 : 365;
}





function dateFromDay(year, day){
	const date = new Date(year, 0);
	const doyDate = new Date(date.setDate(day));
	return doyDate.toLocaleDateString('en-US');
}





function isLeapYear(year) {
	if ((year & 3) !== 0) return false;
	return ((year % 100) !== 0 || (year % 400) === 0);
}





function createCalendar(year, db, container) {
	const days = getTotalDays(year);
	const calendar = createNewElement('ul', 'calendar');
	//const data = db.map(item => {});
	for (let d=1; d<=days; d++) {
		const calendarItem = createNewElement('li', 'calendar__day calendar__day--' + d, dateFromDay(year, d));
		calendar.appendChild(calendarItem);
	}
	container.appendChild(calendar);
}





export {
	createCalendar,
	getTotalDays,
	dateFromDay
};
