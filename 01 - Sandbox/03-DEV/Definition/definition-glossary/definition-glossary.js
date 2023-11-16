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

	// if on glossary page, create Go Back Link.
	if((window.location.href).includes('glossary.html#') && !(window.location.href).includes('definition-glossary.html')){
		let wordsToDefineEl2 = document.querySelectorAll('.rcn-definition__def-title');

		wordsToDefineEl2.forEach(el => {
			let id = el.getAttribute('id');
			let definition = document.querySelector(`#${id}`);
			definition = definition.nextElementSibling;
			let goBackLink = document.createElement('a');
			goBackLink.setAttribute('href', `./definition-glossary.html#${id}`);
			goBackLink.setAttribute('title', 'Retourner à la lecture');
			goBackLink.classList.add('rcn-definition__link');
			goBackLink.innerHTML = '  Retourner à la lecture ';
			console.log(goBackLink);
			definition.appendChild(goBackLink);
		})
	}
});