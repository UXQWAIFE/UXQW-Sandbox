let wordsToDefineEl = document.querySelectorAll('[data-def]');
let modal = document.querySelector('.rcn-modalOverlayedContainer');
let modalTitle = document.querySelector('.rcn-modal__title');
let modalContent = document.querySelector('.rcn-modal__content');
let button = document.querySelector('.rcn-modal__closeButton');

window.addEventListener('load', (event) => {
	wordsToDefineEl.forEach(el => {
		const defID = `def-${el.innerHTML.toLowerCase()}`;
		el.setAttribute('data-def', el.innerHTML.toLowerCase());
		el.setAttribute('title', 'Acceder à la definition');
		el.setAttribute('href', `#${defID}`);
		el.classList.add('rcn-definition__link');
	});
});	

wordsToDefineEl.forEach(element => {
	element.addEventListener('click', (event) => {
		const word = element.getAttribute('data-def');
		modalTitle.innerHTML = `Definition de ${word}`;
		let defList = document.createElement('dl');
		let defTitle = document.createElement('dt');
		defTitle.innerHTML = word;
		let defText = document.createElement('dd');
		defText.innerHTML = `<p>${dictionary[word]}</p>`;
		defList.appendChild(defTitle);
		defList.appendChild(defText);
		modalContent.append(defList);
		showModal();
	});
});

button.addEventListener('click', (event) => {
	hideModal();
});

function hideModal(){
	modal.classList.add('rcn-modal--hidden');
	modal.classList.remove('rcn-modal--visible');
	modal.setAttribute('aria-hidden', 'true')
}

function showModal(){
	modal.classList.add('rcn-modal--visible');
	modal.classList.remove('rcn-modal--hidden');
	modal.setAttribute('aria-hidden', 'false')
}

dictionary = {
	maxime: 'Corps de texte de la definition. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum numquam beatae impedit est praesentium! Fugit velit sunt saepe, labore accusamus quasi perspiciatis reiciendis molestiae animi obcaecati repellat aut quos excepturi?',
	nobis: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde delectus necessitatibus ab odit nisi non, corrupti architecto veritatis enim, repellat earum quo tenetur. Tempore assumenda vero quidem doloremque libero neque explicabo voluptatem itaque suscipit quod enim, possimus esse beatae laborum, quisquam ipsa expedita error adipisci laboriosam saepe ex a necessitatibus?'
}