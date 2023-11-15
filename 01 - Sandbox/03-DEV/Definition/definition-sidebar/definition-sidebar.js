let wordsToDefineEl = document.querySelectorAll('[data-def]');
let sidebar = document.querySelector('.rcn-definition-sidebar');
let closeButton = document.querySelector('.rcn-definition-sidebar__close-button')

//get all defintions on page & generate ID and random dev defintion
window.addEventListener('load', (event) => {
	wordsToDefineEl.forEach(el => {
		const id = uniqueID();
		const word = el.innerHTML;

		el.setAttribute('data-def', id);
		el.setAttribute('href', `#def-${id}`);
		el.setAttribute('title', 'Accèder à la définition');
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

closeButton.addEventListener('click', (event) => {
	hideSidebar();
});

//Functions
function displaySidebar(){
	sidebar.classList.add('rcn-definition-sidebar--opened');
	sidebar.classList.remove('rcn-definition-sidebar--closed');
	sidebar.setAttribute('aria-hidden', 'false');
}

function hideSidebar(){
	sidebar.classList.add('rcn-definition-sidebar--closed');
	sidebar.classList.remove('rcn-definition-sidebar--opened');
	sidebar.setAttribute('aria-hidden', 'true');
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