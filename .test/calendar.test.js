/* eslint-disable no-undef */
import {getTotalDays, dateFromDay} from '../assets/js/calendar.js';

describe('Leap year tests', () => {

	test('Year 2020 has 366 days', () => {
		const input = 2020;
		const result = 366;
		expect(getTotalDays(input)).toBe(result);
	});

	test('Year 1973 had 365 days', () => {
		const input = 1973;
		const result = 365;
		expect(getTotalDays(input)).toBe(result);
	});

});





describe('Date functions', () => {
	test('The return value is a string', ()=> {
		expect(typeof dateFromDay(2020, 3) === 'string').toBe(true);
	});
	test('The 3rd day of the 2020 year is 1/3/2020', ()=> {
		expect(dateFromDay(2020, 3)).toBe('1/3/2020');
	});
});
