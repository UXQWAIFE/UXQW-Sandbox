const btnMoreText = document.querySelector('.rcn-buttonAsLink');

btnMoreText.addEventListener('click', function() {
  const textDescription = document.querySelector('.rcn-card__textDescription');

  if (textDescription.classList.contains('rcn-card__textDescription--expanded')) {
    textDescription.classList.remove('rcn-card__textDescription--expanded');
     btnMoreText.innerHTML = 'Afficher plus <i class="rcn-icon rcn-icon--mdi-chevron-down"></i>';
  } else {
    textDescription.classList.add('rcn-card__textDescription--expanded');
    btnMoreText.innerHTML = 'Afficher moins <i class="rcn-icon rcn-icon--mdi-chevron-up"></i>' ;
  }
});