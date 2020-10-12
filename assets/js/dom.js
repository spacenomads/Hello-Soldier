function newElement(element, elementClass, elementContent='') {
	const newElement = document.createElement(element);
	newElement.className = elementClass;
	const newContent = document.createTextNode(elementContent);
	elementContent && newElement.appendChild(newContent);

	return newElement;
}

export {newElement};
