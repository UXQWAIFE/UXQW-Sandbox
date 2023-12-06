const moreButton = document.querySelectorAll('.rcn-card__showMoreButton');
const checkbox = document.querySelectorAll('.rcn-inputField__input--checkbox');
const chevron = document.querySelectorAll('.rcn-card__actionsZone .rcn-icon--mdi-chevron-down , .rcn-card__actionsZone .rcn-icon--mdi-chevron-up');
console.log(chevron)


//expands description on button click
moreButton.forEach(button => {
	const txtDescription = button.previousElementSibling;
	button.addEventListener('click', event => {
		if(txtDescription.classList.contains('rcn-card__textDescription--expanded')){
			txtDescription.classList.remove('rcn-card__textDescription--expanded');
			button.innerHTML = `Afficher plus <i class="rcn-icon rcn-icon--mdi-chevron-down"></i>`
		}else{
			txtDescription.classList.add('rcn-card__textDescription--expanded');
			button.innerHTML = `Afficher moins <i class="rcn-icon rcn-icon--mdi-chevron-up"></i>`
		}
	});
});

// changes classes depending on checkbox status
checkbox.forEach(box => {
	box.addEventListener('click', event => {
		const card = box.closest('.rcn-card--cardsTable');
		if(box.checked){
			card.classList.add('rcn-card--selected');
		}else{
			card.classList.remove('rcn-card--selected');
		}
	})
})

// displays or hides dropdown content on click on chevron
chevron.forEach(icon => {
	const dropdown = icon.parentElement.parentElement.parentElement.nextElementSibling;
	icon.addEventListener('click', event => {
		if(dropdown.classList.contains('rcn-card__dropDownContent--expanded')){
			dropdown.classList.remove('rcn-card__dropDownContent--expanded');
			icon.classList.remove('rcn-icon--mdi-chevron-up');
			icon.classList.add('rcn-icon--mdi-chevron-down');
		}else{
			dropdown.classList.add('rcn-card__dropDownContent--expanded');
			icon.classList.remove('rcn-icon--mdi-chevron-down');
			icon.classList.add('rcn-icon--mdi-chevron-up');
		}
	});
});