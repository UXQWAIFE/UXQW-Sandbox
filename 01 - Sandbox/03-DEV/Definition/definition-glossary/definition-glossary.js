let wordsToDefineEl = document.querySelectorAll('[data-def]');


window.addEventListener('load', (event) => {
	wordsToDefineEl.forEach(el => {
		const defID = `def-${el.innerHTML}`;
		el.setAttribute('data-def', el.innerHTML);
		el.setAttribute('href', `./glossary.html#${defID}`);
		el.setAttribute('title', 'Accèder à la définition');
		el.classList.add('rcn-definition__link');
	});
});

