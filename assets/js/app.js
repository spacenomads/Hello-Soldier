import {createCalendar} from './calendar.js';





const CURRENT_YEAR = 2020;
const app = document.querySelector('.js__app');
const buttonAuth = app.querySelector('.js-button-auth');
const buttonOut = app.querySelector('.js-button-out');
const divCms = app.querySelector('.js-cms');
const selectDay = app.querySelector('.js-day');
const divEntries = app.querySelector('.js-entries');
const radioGoodDay = app.querySelector('.js-goodDay');
const radioBadDay = app.querySelector('.js-badDay');
const divCommentContainer = app.querySelector('.js-comment-container');
const inputComment = app.querySelector('.js-comment');
const cal = app.querySelector('.calendar__outer');





// Your web app's Firebase configuration
const FIREBASECONFIG = {
	apiKey: 'AIzaSyAUnf5mCG7bqxrrtytv95R8MRznFX9Psy8',
	authDomain: 'hello-soldier.firebaseapp.com',
	databaseURL: 'https://hello-soldier.firebaseio.com',
	projectId: 'hello-soldier',
	storageBucket: 'hello-soldier.appspot.com',
	messagingSenderId: '413393423185',
	appId: '1:413393423185:web:6b85cb07095d4339'
};

// Initialize Firebase
firebase.initializeApp(FIREBASECONFIG);

// Set Firebase vars
const auth = firebase.auth();
const provider = new firebase.auth.GoogleAuthProvider();
const database = firebase.database();

// Firebase auth methods
auth.onAuthStateChanged(onAuthStateChanged.bind(this));





// Form methods
function checkIfEntryIsRight() {
	let isRight = true
	if(!selectDay.value || (!radioGoodDay.checked && !radioBadDay.checked) ){
		isRight = false
	}
	return isRight
}

function checkStatus() {
	if (radioGoodDay.checked) {
		divCommentContainer.style.display = 'block';
	} else {
		inputComment.value = null
		divCommentContainer.style.display = 'none';
	}
}

function getEmojiToSend(){
	var emoji = '?'
	if (radioGoodDay.checked) {
		emoji = ':)'
	} else if (radioBadDay.checked) {
		emoji = ':('
	}
	return emoji
}

// Auth methods
function openAuth() {
	auth.signInWithPopup(provider);
}

function signOut () {
	auth.signOut();
}

function onAuthStateChanged(user) {
	if(user){
		console.log('El que poner en las rules es', user);
		// console.log(user, user.photoURL, user.displayName, user.email);
		buttonOut.style.display = 'inline'
		buttonAuth.style.display = 'none'
		divCms.style.display = 'inline'
	} else {
		buttonAuth.style.display = 'inline'
		buttonOut.style.display = 'none'
		divCms.style.display = 'none'
	}
}

// DB methods
function readDB () {
	const entriesRef = database.ref('/' + CURRENT_YEAR);
	entriesRef.on('value', function(snapshot) {
		if(snapshot.val()) {
			//renderEntries(snapshot.val());
			console.log(snapshot.val());
			createCalendar(CURRENT_YEAR, snapshot.val(), cal);
		}
	});
}

function writeDB () {
	if (checkIfEntryIsRight()) {
		var year = selectDay.value.substr(0,4)
		console.log(selectDay);
		// database.ref(year + '/' + selectDay.valueAsNumber).set({
		// 	status: getEmojiToSend(),
		// 	comment: inputComment.value
		// });
		inputComment.value = null
	}
}

function renderEntries (object) {
	divEntries.innerHTML = '';
	var year = (object[CURRENT_YEAR]);
	for (const property in year) {
		let date = new Date(Number(property)).toDateString()
		divEntries.innerHTML += '<div>'
		divEntries.innerHTML += date + ' / ' + year[property].status
		if(year[property].comment) {
			divEntries.innerHTML +=  ' / comment: ' + year[property].comment
		}
		divEntries.innerHTML += '</div>'
	}
}





// Read DB
readDB();

