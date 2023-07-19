<!DOCTYPE html>
<html lang="en">
<head>
	<?php session_start(); ?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="asset/RCN-DesignSystem/assets/reset.css">
	<link rel="stylesheet" href="asset/RCN-DesignSystem/assets/styles-ChorusPro.css">
	<link rel="stylesheet" href="asset/data-form/table_general.css">
	<link rel="stylesheet" href="asset/data-form/table_structure.css">
	<style>
	* {
		box-sizing: border-box;
	}
    section:first-child:not(main section) {
        display:grid;
        grid-template-columns: 1fr 1fr 1fr;
    }
    section:not(.table_holder) div {
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
	.table_holder {
		display:block;
		margin:0;
	}
	.table_holder > h2, .table_holder > p {
		margin:2rem 0;
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

	.show {
		display:block;
	}
	.hide {
		display:none;
	}
	#seeMore {
		position:relative;
	}
	#colonnesContainer {
		display: flex;
		gap: 1.5rem;
		flex-wrap: wrap;
		max-width: 80vw;
	}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">

</head>
<body>
<?php

// Supprimer les valeurs de la session une fois récupérées (facultatif)
print_r($_SESSION);

?>
    <section>
        <a href="../">Retour en arriere</a>
    </section>
	<section id="seeMore" class="show">
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
	<button id="hideHeader">hide me</button>
	<main>
	<form action="table_generative.php" method="POST">
		<div class="rcn-inputFieldBloc rcn-inputFieldBloc--inline">
			<div class="rcn-inputField">
			<input value="<?php echo isset($_SESSION['nombreColonnes']) ? $_SESSION['nombreColonnes'] : ''; ?>" class="rcn-inputField__input" type="number" id="nombreColonnes" name="nombreColonnes" placeholder="Nombre de colonnes">
			</div>  
			<div class="rcn-inputField">
			<input value="<?php echo isset($_SESSION['nombreLignes']) ? $_SESSION['nombreLignes'] : ''; ?>" class="rcn-inputField__input" type="number" id="nombreLignes" name="nombreLignes" placeholder="Nombre de lignes">
			</div>
			<button class="rcn-button rcn-button--secondary" type="button" onclick="genererListesDeroulantes()">Générer les listes déroulantes</button>
		</div>

		<div id="colonnesContainer"></div>

		<fieldset class="rcn-inputFieldBloc rcn-inputFieldBloc--checkboxOrRadio">
			<legend>En tête</legend>

			<label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio rcn-inputFieldBloc__label--checkboxOrRadio-checked" for="ET_Searchable">Recherche ?
			<input <?php echo isset($_SESSION['ET_Searchable']) && $_SESSION['ET_Searchable'] ? 'checked' : ''; ?> value="" class='rcn-icon rcn-inputField__input rcn-inputField__input--checkbox' type="checkbox" name="ET_Searchable" id="ET_Searchable">
			</label>

			<label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio rcn-inputFieldBloc__label--checkboxOrRadio-checked" for="ET_Action">Actions globales (dont export) ?
			<input <?php echo isset($_SESSION['ET_Action']) && $_SESSION['ET_Action'] ? 'checked' : ''; ?> value="" class='rcn-icon rcn-inputField__input rcn-inputField__input--checkbox' type="checkbox" name="ET_Action" id="ET_Action">
			</label>

			<label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio rcn-inputFieldBloc__label--checkboxOrRadio-checked" for="ET_Pagination" >Pagination ?
			<input <?php echo isset($_SESSION['ET_Pagination']) && $_SESSION['ET_Pagination'] ? 'checked' : ''; ?> value="" class='rcn-icon rcn-inputField__input rcn-inputField__input--checkbox' type="checkbox" name="ET_Pagination" id="ET_Pagination">
			</label>
		</fieldset>

		<fieldset class="rcn-inputFieldBloc rcn-inputFieldBloc--checkboxOrRadio">
			<legend>Action de colonne</legend>

			<label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio rcn-inputFieldBloc__label--checkboxOrRadio-checked" for="Col_fix">Colonne Fixe ?
			<input <?php echo isset($_SESSION['Col_fix']) && $_SESSION['Col_fix'] ? 'checked' : ''; ?> value="" class='rcn-icon rcn-inputField__input rcn-inputField__input--checkbox' type="checkbox" name="Col_fix" id="Col_fix">
			</label>

			<label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio rcn-inputFieldBloc__label--checkboxOrRadio-checked" for="Col_filtre">Colonne Filtrable ?
			<input <?php echo isset($_SESSION['Col_filtre']) && $_SESSION['Col_filtre'] ? 'checked' : ''; ?> value="" class='rcn-icon rcn-inputField__input rcn-inputField__input--checkbox' type="checkbox" name="Col_filtre" id="Col_filtre">
			</label>

			<label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio rcn-inputFieldBloc__label--checkboxOrRadio-checked" for="Col_action">Colonne Action ?
			<input <?php echo isset($_SESSION['Col_action']) && $_SESSION['Col_action'] ? 'checked' : ''; ?> value="" class='rcn-icon rcn-inputField__input rcn-inputField__input--checkbox' type="checkbox" name="Col_action" id="Col_action">
			</label>
		</fieldset>

		<fieldset class="rcn-inputFieldBloc rcn-inputFieldBloc--checkboxOrRadio">
			<legend>Action de ligne</legend>
			<label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio rcn-inputFieldBloc__label--checkboxOrRadio-checked" for="Lig_depliable">Ligne dépliable ?
				<input <?php echo isset($_SESSION['Lig_depliable']) && $_SESSION['Lig_depliable'] ? 'checked' : ''; ?> value="" class='rcn-icon rcn-inputField__input rcn-inputField__input--checkbox' type="checkbox" name="Lig_depliable" id="Lig_depliable">
			</label>
			<label class="rcn-inputFieldBloc__label sr-only" for="Lig_depliable_nbr">Nombre ?</label>
			<div class="rcn-inputField">
				<input placeholder="Nombre" value="<?php echo isset($_SESSION['Lig_depliable_nbr']) ? $_SESSION['Lig_depliable_nbr'] : ''; ?>" class='rcn-inputField__input' type="number" name="Lig_depliable_nbr" id="Lig_depliable_nbr">
			</div>	


			<label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio rcn-inputFieldBloc__label--checkboxOrRadio-checked" for="Lig_select">Ligne Selectionnable ?
				<input <?php echo isset($_SESSION['Lig_select']) && $_SESSION['Lig_select'] ? 'checked' : ''; ?> value="" class='rcn-icon rcn-inputField__input rcn-inputField__input--checkbox' type="checkbox" name="Lig_select" id="Lig_select">
			</label>
		</fieldset>

		<button class="rcn-button rcn-button--primary" type="submit">Créer le tableau</button>
	</form>

		
	<section class="table_holder">
		
		<?php
			// Vérifier si le fichier du tableau existe
			if (file_exists("tableau.html")) {
				// Inclure le contenu du fichier
				include "tableau.html";
			}
		?>
	</section>
	</main>
	<script>
		function genererListesDeroulantes() {
			var nombreColonnes = parseInt(document.getElementById("nombreColonnes").value);
			var colonnesContainer = document.getElementById("colonnesContainer");
				colonnesContainer.innerHTML = "";

				for (var col = 1; col <= nombreColonnes; col++) {
					var fieldset = document.createElement("fieldset");
					var legend = document.createElement("legend");
					legend.textContent = "Colonne " + col;
					fieldset.appendChild(legend);

					var label = document.createElement("label");
					label.setAttribute("for", "typeDonnee" + col);
					label.textContent = "Type de donnée : ";
					fieldset.appendChild(label);

					var div = document.createElement("div");
					div.classList.add("rcn-inputField"); 

					var select = document.createElement("select");
					select.classList.add("rcn-inputField__input", "rcn-inputField__input--select"); 
					select.setAttribute("name", "typeDonnee" + col);
					select.setAttribute("id", "typeDonnee" + col);


					var options = [
					{ value: "texte", text: "Texte" },
					{ value: "nombre", text: "Nombre" },
					{ value: "lien", text: "Lien" },
					{ value: "telephone", text: "Numéro de téléphone" },
					{ value: "icone", text: "Icône" },
					{ value: "bouton_selection", text: "Bouton de sélection" },
					{ value: "bouton_depliable", text: "Bouton dépliable" },
					{ value: "bouton_action", text: "Bouton d'action" }
					];

					for (var i = 0; i < options.length; i++) {
					var option = document.createElement("option");
					option.value = options[i].value;
					option.text = options[i].text;
					select.appendChild(option);
					div.appendChild(select);
					}

					fieldset.appendChild(div);
					colonnesContainer.appendChild(fieldset);
				}

			}
			var checkbox = document.getElementById("Lig_depliable");
			var numberField = document.getElementById("Lig_depliable_nbr");

			// Écouter l'événement de modification de la case à cocher
			checkbox.addEventListener("change", function() {
			// Vérifier si la case à cocher est cochée
			if (checkbox.checked) {
				// Afficher le champ de nombre
				numberField.style.display = "block";
			} else {
				// Masquer le champ de nombre
				numberField.style.display = "none";
			}
			});
	</script>
</body>
</html>