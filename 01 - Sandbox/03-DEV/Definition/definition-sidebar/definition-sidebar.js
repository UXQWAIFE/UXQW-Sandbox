let wordsToDefineEl = document.querySelectorAll('[data-def]');
let sidebar = document.querySelector('.rcn-definition-sidebar');
let closeButton = document.querySelector('.rcn-button');
let overlay = document.querySelector('.definition-overlay');

//get all defintions on page & generate ID and random dev defintion
window.addEventListener('load', (event) => {
	wordsToDefineEl.forEach(el => {
		const id = uniqueID();
		const word = el.innerHTML;

		el.setAttribute('data-def', id);
		el.setAttribute('href', `#def-${id}`);
		el.setAttribute('title', 'Accèder à la définition');
		el.setAttribute('id', `word-${id}`);
		el.classList.add('rcn-definition__link');
		generateDef(id, word);
	});
});

//open sidebar on click
wordsToDefineEl.forEach(element => {
	element.addEventListener('click', (event) => {
		displaySidebar();
	});
});

//close sidebar on icon click
closeButton.addEventListener('click', (event) => {
	hideSidebar();
});

//close sidebar on Esc
sidebar.addEventListener('keydown', (event) => {
	if(event.key === 'Escape'){
		hideSidebar();
	}
});

// close sidebar on click anywhere in the page
overlay.addEventListener('click', (event) => {
	hideSidebar();
});

//Functions
function displaySidebar(){
	sidebar.classList.add('rcn-definition-sidebar--opened');
	sidebar.classList.remove('rcn-definition-sidebar--closed');
	overlay.classList.remove('definition-overlay--invisible');
	overlay.classList.add('definition-overlay--visible');
}

function hideSidebar(){
	sidebar.classList.add('rcn-definition-sidebar--closed');
	sidebar.classList.remove('rcn-definition-sidebar--opened');
	overlay.classList.add('definition-overlay--invisible');
	overlay.classList.remove('definition-overlay--visible');
}

//generate unique id
function uniqueID() {
	return Math.floor(Math.random() * Date.now()); 
}

//generate DOM elements for definition (dev)
function generateDef(id, word) {
	//def title
	let definitionTitle = document.createElement('dt');
	definitionTitle.classList.add('rcn-definition__list-title');
	definitionTitle.setAttribute('id', `def-${id}`);
	definitionTitle.innerHTML = word;

	//def text
	let definition = document.createElement('dd');
	definition.classList.add('rcn-definition__list-content');
	let defText = generateLoremText(Math.ceil(Math.random() * 5), Math.ceil(Math.random() * 25));
	definition.innerHTML = `<p>${defText}</p>`;

	const sidebarContent = document.querySelector('.rcn-definition__list');
	sidebarContent.appendChild(definitionTitle); 
	sidebarContent.appendChild(definition); 

	//Append for SR
	const defList = document.querySelector('.rcn-definition-footnotes');
	let currentDef = document.querySelector(`#def-${id}`).nextElementSibling;
	let goBackLink = document.createElement('a');
	goBackLink.setAttribute('href', `#word-${id}`);
	goBackLink.setAttribute('title', 'Retourner à la lecture');
	goBackLink.classList.add('rcn-definition__link');
	goBackLink.innerHTML = '  Retourner à la lecture ';
	currentDef.appendChild(goBackLink);

	defList.appendChild(definitionTitle.cloneNode(true));
	defList.appendChild(currentDef);
}

//generate lorem definition
function generateLoremText(numParagraphs, numWords) {
	var loremText = '';
	var words = [
		'Lorem', 'ipsum', 'dolor', 'sit',
		'amet', 'consectetur', 'adipiscing',
		'elit', 'sed', 'do', 'eiusmod', 'tempor',
		'incididunt', 'ut', 'labore', 'et',
		'dolore', 'magna', 'aliqua', 'Ut', 'enim',
		'ad', 'minim', 'veniam', 'quis', 'nostrud',
		'exercitation', 'ullamco', 'laboris', 'nisi',
		'ut', 'aliquip', 'ex', 'ea', 'commodo',
		'consequat', 'Duis', 'aute', 'irure',
		'dolor', 'in', 'reprehenderit', 'in',
		'voluptate', 'velit', 'esse', 'cillum',
		'dolore', 'eu', 'fugiat', 'nulla', 'pariatur',
		'Excepteur', 'sint', 'occaecat', 'cupidatat',
		'non', 'proident', 'sunt', 'in', 'culpa', 'qui',
		'officia', 'deserunt', 'mollit', 'anim', 'id',
		'est', 'laborum',
		];
	
		for (var i = 0; i < numParagraphs; i++) {
			var paragraph = '';
			for (var j = 0; j < numWords; j++) {
			var randomWord = words[Math.floor(Math.random() * words.length)];
			paragraph += randomWord + ' ';
			}
			loremText += '' + paragraph + '';
		}
		return loremText;
	}