# Definition

**Table of content:**
- [Cas d'usage](#usage)
- [Positionnement dans la page](#positionnement)
- [Typologie](#typologie)
- [Developement](#dev)
	- [Cas de notes de bas de page](#dev-notes)
	- [Cas du glossaire](#dev-glossaire)
	- [Cas de la modale](#dev-modale)
	- [Cas de la sidebar](#dev-sidebar)

---
**NOTE**
Les classes sont placées à titre indicatif, elles ne sont pas encore mises en place dans le RCN.

---
<a id="usage"></a>
## Cas d'usage
Une définition est une explication d'un mot ou d'un concept. Une définition apparaît sous forme de lien menant à la signification du mot. Elle permet d'aider l'utilisateur à mieux comprendre les mots difficiles ou mal connus, et ainsi rendre la lecture plus comprehensible.
La définition est une aide optionnelle. L'utilisateur ne doit pas être obligé de la consulter pour suivre sa lecture.

<a id="positionnement"></a>
### Positionnement dans la page
Une definition est un bloc de texte qui peut se trouver à plusieurs endroits de la page selon les cas :
- notes de bas de page
- dans une fenêtre laterale
- dans une modale
- dans une page specifique Glossaire   

Chaque définition est appelée grace à un lien ou un bouton (en fonction du cas d'usage) dans le texte courant.   
Dans le cas de nombreuses définitions dans une même page, on privilegera le glossaire ou la modale aux notes de bas de page.

<a id="typologie"></a>
### Typologie
L'appel de la définition doit 
- Doit être style comme les liens
- Doit être positionne mot par mot
- Doit être accessible à la navigation au clavier

Les définitions 
- Ne doivent pas contenir d'information essentielle à la suite de la lecture
- Sont composées des balises sémantiques `<dl>`, `<dt>` et `<dd>`.

<a id="dev"></a>
## Développement
<a id="dev-notes"></a>
### 1 - Cas de notes de bas de page
Les définitions sont constituées d'un appel via un lien sur le mot à définir, et de la définition du mot en elle-même située dans une autre partie de la page. La navigation entre le lien et la définition en bas de page doit être dynamique, c'est à dire que le lien partant d'un mot doit mener à ce mot specifiquement. 
Il en est de même pour le retour à la lecture, le retour doit pointer sur le mot recherche, pour que le lecteur puisse reprendre sa lecture sans navigation supplémentaire.

#### Declaration
```html
<a  class="rcn-definition__link"
	data-def="lorem" 
	href="#def-lorem" 
	id="word-lorem" 
	title="Accèder à la définition">
	Lorem
</a>	
```

La balise `<a>` doit contenir :
- la classe `rcn-definition__link`
- l'attribut custom `data-def` permettant d'identifier toutes les définitions dans une même page.
- l'attribut `href="#id"` permettant de pointer vers la signification du mot
- l'attribut `id=[ID]` faisant office d'ancre pour le retour à la lecture
- l'attribut `title=[Description]` indiquant à l'utilisateur le but de la navigation.

Le bloc de définition est à placer en bas de page et doit utiliser la semantique specifique pour les definitions. 

```html
<dl class="rcn-definition-footnotes">
	<dt id="def-lorem" class="rcn-definition__def-title">Lorem</dt>
	<dd>
		<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum numquam beatae impedit est praesentium! Fugit velit sunt saepe, labore accusamus quasi perspiciatis reiciendis molestiae animi obcaecati repellat aut quos excepturi?</p>
		<a  href="#word-lorem" 
			title="Retourner à la lecture" 
			class="rcn-definition__link">
			Retourner à la lecture 
		</a>
	</dd>
</dl>
```

La liste de definitions `<dl>` est composée de paires de titre de définition `<dt>` et de détail de la définition `<dd>`.  La balise `<dd>` contient une balise `<p>` contenant la signification du mot et un lien `<a>` pour le retour à la lecture. 

La balise `<dl>` doit contenir : 
- la classe `rcn-definition-footnotes`

La balise `<dt>` doit contenir :
- Le mot à definir
- la classe `rcn-definition__def-title`

La balise `<dd>` doit contenir : 
- une balise `<p>`
- une balise `<a>`

La balise `<p>` doit contenir :
- Le corps de texte de la definition

La balise `<a>` doit contenir : 
- Un texte clair indiquant vers ou la navigation se fait
- La classe `rcn-definition__link`
- L'attribut `title=[Description]` indiquant à l'utilisateur le but de la navigation.
- l'attribut `href="#id"` permettant de pointer vers le contenu de la page ou s'est arrêté la lecture de l'utilisateur (l'appel de définition).

Pour simplifier le travail des rédacteurs et les erreurs, il est envisageable de gérer les attributs via un script javascript.

```js
let wordsToDefineEl = document.querySelectorAll('[data-def]');

window.addEventListener('load', (event) => {
	wordsToDefineEl.forEach(el => {
		const defID = `def-${el.innerHTML.toLowerCase()}`; // ici ID sur la definition
		const wordID = `word-${el.innerHTML.toLowerCase()}`; // ici ID sur l'appel de la definition'
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
```

<a id="dev-glossaire"></a>
### 2 - Cas du glossaire
Les définitions sont constituées d'un appel via un lien sur le mot à definir, et de la definition du mot en elle-même située dans une autre page, la page Glossaire.      
La navigation entre le lien et la définition doit être dynamique, c'est à dire que le lien partant d'un mot doit mener à ce mot spécifiquement. 
Il en est de même pour le retour à la lecture, le retour doit pointer sur le mot recherche, pour que le lecteur puisse reprendre sa lecture sans navigation supplémentaire.

#### Declaration
```html
<a  class="rcn-definition__link"
	data-def="lorem" 
	href="./glossary.html#def-lorem" 
	id="def-lorem" 
	title="Accèder à la définition">
	Lorem
</a>	
```

La balise `<a>` doit contenir :
- la classe `rcn-definition__link`
- l'attribut custom `data-def` permettant d'identifier toutes les définitions dans une même page.
- l'attribut `href="[path]#id"` permettant de pointer vers la signification du mot
- l'attribut `id=[ID]` faisant office d'ancre pour le retour à la lecture
- l'attribut `title=[Description]` indiquant à l'utilisateur le but de la navigation.

Le bloc de définition est à placer dans une page spécifique (ex: `glossary.html`) et doit utiliser la sémantique spécifique pour les definitions.

```html
<dl class="rcn-definition-footnotes">
	<dt id="def-lorem" class="rcn-definition__def-title">Lorem</dt>
	<dd>
		<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum numquam beatae impedit est praesentium! Fugit velit sunt saepe, labore accusamus quasi perspiciatis reiciendis molestiae animi obcaecati repellat aut quos excepturi?</p>
		<a  href="./index.html#def-lorem" 
			title="Retourner à la lecture" 
			class="rcn-definition__link">
			Retourner à la lecture 
		</a>
	</dd>
</dl>
```
La liste de définitions `<dl>` est composée de paires de titre de définition `<dt>` et de détail de la définition `<dd>`.  La balise `<dd>` contient une balise `<p>` contenant la signification du mot et un lien `<a>` pour le retour à la lecture. 

La balise `<dl>` doit contenir : 
- la classe `rcn-definition-footnotes`

La balise `<dt>` doit contenir :
- Le mot à definir
- la classe `rcn-definition__def-title`

La balise `<dd>` doit contenir : 
- une balise `<p>`
- une balise `<a>`

La balise `<p>` doit contenir :
- Le corps de texte de la definition

La balise `<a>` doit contenir : 
- Un texte clair indiquant vers ou la navigation se fait
- La classe `rcn-definition__link`
- L'attribut `title=[Description]` indiquant à l'utilisateur le but de la navigation.
- l'attribut `href="[path]#id"` permettant de pointer vers le contenu de la page ou s'est arrêté la lecture de l'utilisateur (l'appel de definition).

Pour simplifier le travail des rédacteurs et les erreurs, il est envisageable de gerer les attributs via un script javascript.

```js
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
	if((window.location.href).includes('glossary.html#') && !(window.location.href).includes('index.html')){
		let wordsToDefineEl2 = document.querySelectorAll('.rcn-definition__def-title');

		wordsToDefineEl2.forEach(el => {
			let id = el.getAttribute('id');
			let definition = document.querySelector(`#${id}`);
			definition = definition.nextElementSibling;
			let goBackLink = document.createElement('a');
			goBackLink.setAttribute('href', `./index.html#${id}`);
			goBackLink.setAttribute('title', 'Retourner à la lecture');
			goBackLink.classList.add('rcn-definition__link');
			goBackLink.innerHTML = '  Retourner à la lecture ';
			definition.appendChild(goBackLink);
		})
	}
});
```
<a id="dev-modale"></a>
### 3 - Cas de la modale
<a id="dev-sidebar"></a>
### 4 - Cas de la sidebar
