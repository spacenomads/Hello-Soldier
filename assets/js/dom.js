function createNewElement(el, elClass, elContent='') {
	const element = document.createElement(el);
	element.className = elClass;
	const newContent = document.createTextNode(elContent);
	elContent && element.appendChild(newContent);
	return element;
}





export {createNewElement};
