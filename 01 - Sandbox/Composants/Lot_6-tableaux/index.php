<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
	* {
		box-sizing: border-box;
	}
    section:first-child:not(main section) {
        display:grid;
        grid-template-columns: 1fr 1fr 1fr;
    }
    section div {
        display: inline-flex;
        align-self: center;
    }
	section:last-child ul {
		display: grid;
		grid-template-columns: 1fr 1fr 1fr;
		list-style: none;
		width:100%;
	}
	section {
		display:block;
		width:100%;
		padding: 1rem;
	}
	.list-folder, .list-file {
		display:flex;
		gap:1.5rem;
		width:100%;
		padding:0;
		padding: 1rem 2rem;
		border-top: 1px solid grey;
		list-style: none;
	}
	.list-file {
		overflow-x: scroll;
	}
	.list-folder li {
		display: flex;
		justify-content: left;
		align-items: stretch;
	}
	.list-folder li a {
		display: flex;
		width:100%;
		height:auto;
		color:grey;
		gap:1rem;
		border:2px solid grey;
		background:white;
		border-radius: 5px;
		padding:0.5rem 0.75rem;
		font-weight: 600;
		text-decoration: none;
		flex-direction: row;
	}
	.list-folder li a:hover {
		border:2px solid darkslateblue;
	}
	.list-file li a:hover {
		background:#efefef;
	}
	.list-folder li a:hover, .list-file li a:hover {
		color: darkslateblue;
	}
	.list-folder li a *:last-child, .list-file li a *:last-child {
		display: flex;
		top:0.5rem;
		right:0.75rem;
		width:16px;
		height:16px;
		visibility: hidden;
	}
	.list-folder li a:hover *:last-child, .list-file li a:hover *:last-child {
		display: flex;
		width:16px;
		height:16px;
		visibility: visible;
		align-content: end;
		align-self: center;
		margin: 0 0 0 auto;
	}
	.list-file li a {
		display: flex;
		width:100%;
		height:auto;
		color:grey;
		gap:1rem;
		background:white;
		border-radius: 5px;
		padding:0.5rem 0.75rem;
		font-weight: 600;
		text-decoration: none;
		flex-direction: row;
	}

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">
</head>
<body>
    <section>
        <a href="../">Retour en arriere</a>
    </section>
	<section>
		<?php
			$directory = './'; // Chemin du répertoire à afficher (ici, le répertoire courant)

			// Récupérer la liste des éléments du répertoire
			$elements = scandir($directory);
			
			// Tableaux pour stocker les dossiers et les fichiers
			$dossiers = array();
			$fichiers = array();
			
			// Séparer les dossiers des fichiers
			foreach ($elements as $element) {
				// Exclure les dossiers "." et ".."
				if ($element === '.' || $element === '..') {
					continue;
				}
			
				$elementPath = $directory . $element;
			
				if (is_dir($elementPath)) {
					// C'est un dossier, l'ajouter au tableau des dossiers
					$dossiers[] = $element;
				} else {
					// Vérifier si c'est un fichier .html
					$extension = pathinfo($elementPath, PATHINFO_EXTENSION);
					if ($extension === 'html') {
						// C'est un fichier .html, l'ajouter au tableau des fichiers
						$fichiers[] = $element;
					}
				}
			}
			
			// Trier les dossiers et les fichiers par ordre alphabétique
			sort($dossiers);
			sort($fichiers);
			
			// Afficher les dossiers
			echo '<ul class="list-folder">';
			foreach ($dossiers as $dossier) {
				$dossierPath = $directory . $dossier;
				echo '<li class="folder"><a href="' . $dossierPath . '"><i class="mdi mdi-folder-arrow-right-outline"></i>' . $dossier . '<i class="mdi mdi-arrow-right"></i></a></li>';
			}
			echo '</ul>';
			
			// Afficher les fichiers
			echo '<ul class="list-file">';
			foreach ($fichiers as $fichier) {
				$fichierPath = $directory . $fichier;
				echo '<li class="file"><a href="' . $fichierPath . '"><i class="mdi mdi-file-eye-outline"></i>' . $fichier . '<i class="mdi mdi-arrow-right"></i></a></li>';
			}
			echo '</ul>';
			
		?>

	</section>
	<main>
		<div>
			<h1>Tableau de donnée</h1>
			<button class="ChooseWhatToAdd" attr-path="include/tableGeneral.html" id="addTable">Ajout du tableau</button>
		</div>
		<div>
			<h3>Structure</h3>
			<button class="ChooseWhatToAdd" attr-path="include/title_tableau.html" id="addTable">+ Titre</button>
			<button class="ChooseWhatToAdd">add</button>
			<button class="ChooseWhatToAdd">add</button>
			<button class="ChooseWhatToAdd">add</button>
		</div>

		<section id="include">

		</section>
	</main>
	<footer>
		<script>
			const boutons = document.querySelectorAll('.ChooseWhatToAdd');
			let currentPath = null; // Variable pour stocker le chemin actuellement affiché

			boutons.forEach(bouton => {
				bouton.addEventListener('click', toggleContent);
			});

			function toggleContent(event) {
				const container = document.getElementById('include');
				const path = event.target.getAttribute('attr-path');

				// Vérifier si le bouton actuel est déjà sélectionné
				if (path === currentPath) {
					// Le bouton est déjà sélectionné, nous le désélectionnons
					container.prependChild( '' ); // Supprimer le contenu du conteneur
					currentPath = null; // Réinitialiser le chemin actuel
				} else {
					// Le bouton n'est pas sélectionné, nous chargeons le contenu correspondant
					fetch(path)
					.then(response => response.text())
					.then(html => {
						console.log(html);
						const newElement = document.createElement('div');
						newElement.innerHTML = html;
						console.log(newElement);
						container.prependChild( newElement ); // Ajouter le contenu au conteneur
						currentPath = path; // Mettre à jour le chemin actuel
					})
					.catch(error => {
						console.error('Erreur lors du chargement du fichier HTML', error);
					});
				}
			}
			


		</script>
	</footer>
</body>
</html>