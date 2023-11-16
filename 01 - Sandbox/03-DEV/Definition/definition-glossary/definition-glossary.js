let wordsToDefineEl = document.querySelectorAll('[data-def]');

window.addEventListener('load', (event) => {
	wordsToDefineEl.forEach(el => {
		const defID = `def-${el.innerHTML.toLowerCase()}`;
		el.setAttribute('data-def', el.innerHTML.toLowerCase());
		el.setAttribute('href', `./glossary.html#${defID}`);
		el.setAttribute('id', defID);
		el.setAttribute('title', 'Accèder à la définition');
		el.classList.add('rcn-definition__link');
	});
});

//if on glossary page, create Go Back Link.
if((window.location.href).includes('glossary.html#') && !(window.location.href).includes('definition-glossary.html')){
	var id = window.location.toString().split('#')[1];
	let currentDef = document.querySelector(`#${id}`);
	let goBackLink = document.createElement('a');
	goBackLink.setAttribute('href', `./definition-glossary.html#${id}`);
	goBackLink.setAttribute('title', 'Retourner à la lecture');
	goBackLink.classList.add('rcn-definition__link');
	goBackLink.innerHTML = '  Retourner à la lecture ';
	currentDef.appendChild(goBackLink);
}
