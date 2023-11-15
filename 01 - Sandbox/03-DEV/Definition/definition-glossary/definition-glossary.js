let wordsToDefineEl = document.querySelectorAll('[data-def]');


window.addEventListener('load', (event) => {
	wordsToDefineEl.forEach(el => {
		const defID = `def-${el.innerHTML}`;
		// définir la const pour choper l'url à injecter avec un : const urlFrom = "%RB%urlGet"
		el.setAttribute('data-def', el.innerHTML);
		el.setAttribute('href', `./glossary.html#${defID}`); // ./glossary.html#${defID}{urlFrom}
		el.setAttribute('title', 'Accèder à la définition');
		el.classList.add('rcn-definition__link');
	});
});

