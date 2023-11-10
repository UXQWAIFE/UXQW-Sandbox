var button = document.querySelector('.rcn-tooltip__button');
var label = document.querySelector('.rcn-tooltip__label');
var definition = document.querySelector('.rcn-tooltip__definition');
var tooltipButton = document.querySelector('#tooltip-button');
var tooltipLabel = document.querySelector('#tooltip-input');
var tooltipDefinition = document.querySelector('#tooltip-def');
var focusEvents = ['mouseover', 'focus'];
var unfocusEvents = ['mouseout', 'blur'];

button.addEventListener('keydown', (event) => {
	if(event.key === 'Escape'){
		button.blur();
	}
});

focusEvents.forEach( event => {
	button.addEventListener(event, addAccessAttribute);
	label.addEventListener(event, addAccessAttribute);
	definition.addEventListener(event, addAccessAttribute);

});

unfocusEvents.forEach(event => {
	button.addEventListener(event, removeAccessAttribute);
	label.addEventListener(event, removeAccessAttribute);
	definition.addEventListener(event, removeAccessAttribute);
})

function addAccessAttribute(){
	tooltipButton.setAttribute('aria-hidden', 'false');
	tooltipLabel.setAttribute('aria-hidden', 'false');
	tooltipDefinition.setAttribute('aria-hidden', 'false');
};

function removeAccessAttribute(){
	tooltipButton.setAttribute('aria-hidden', 'true');
	tooltipLabel.setAttribute('aria-hidden', 'true');
	tooltipDefinition.setAttribute('aria-hidden', 'true');
	tooltipDefinition.style.display="none";
};



//tooltip on definition appears everytime.
definition.addEventListener('mouseover', event=>{
	tooltipDefinition.style.display="block";
});

definition.addEventListener('mouseout', event=>{
	tooltipDefinition.style.display="none";
});