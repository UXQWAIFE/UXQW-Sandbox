let wordsToDefineEl = document.querySelectorAll('[data-def]');

window.addEventListener('load', (event) => {
	wordsToDefineEl.forEach(el => {
		const defID = `def-${el.innerHTML.toLowerCase()}`;
		const wordID = `word-${el.innerHTML.toLowerCase()}`;
		el.setAttribute('data-def', el.innerHTML.toLowerCase());
		el.setAttribute('href', `#${defID}`);
		el.setAttribute('id', wordID);
		el.setAttribute('title', 'Accèder à la définition');
		el.classList.add('rcn-definition__link');
		let currentDef = document.querySelector(`#${defID}`).nextElementSibling;
		let goBackLink = document.createElement('a');
		goBackLink.setAttribute('href', `#${wordID}`);
		goBackLink.setAttribute('title', 'Retourner à la lecture');
		goBackLink.classList.add('rcn-definition__link');
		goBackLink.innerHTML = '  Retourner à la lecture ';
		currentDef.appendChild(goBackLink);
	});
});