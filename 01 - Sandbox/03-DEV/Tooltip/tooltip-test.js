var button = document.querySelector('.rcn-tooltip');
var tooltipButton = document.querySelector('#tooltip-textbox');
var focusEvents = ['mouseover', 'focus'];
var unfocusEvents = ['mouseout', 'blur'];

button.addEventListener('keydown', (event) => {
	if(event.key === 'Escape'){
		button.blur();
	}
});

focusEvents.forEach( event => {
	button.addEventListener(event, addAccessAttribute);
});

unfocusEvents.forEach(event => {
	button.addEventListener(event, removeAccessAttribute);
});

function addAccessAttribute(){
	tooltipButton.setAttribute('aria-hidden', 'false');
};

function removeAccessAttribute(){
	tooltipButton.setAttribute('aria-hidden', 'true');
};