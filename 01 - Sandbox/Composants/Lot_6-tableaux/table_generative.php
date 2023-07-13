<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Récupérer les données du formulaire
  $nombreColonnes = $_POST["nombreColonnes"];
  $nombreLignes = $_POST["nombreLignes"];

  // Récupérer les options des fonctionnalités
  $ET_Searchable = isset($_POST["ET_Searchable"]);
  $ET_Action = isset($_POST["ET_Action"]);
  $ET_Pagination = isset($_POST["ET_Pagination"]);
  $Col_fix = isset($_POST["Col_fix"]);
  $Col_filtre = isset($_POST["Col_filtre"]);
  $Col_action = isset($_POST["Col_action"]);
  $Lig_depliable = isset($_POST["Lig_depliable"]);
  $Lig_select = isset($_POST["Lig_select"]);

  // Tableau de correspondance des types de données par colonne
  $typesDonnees = [];

  for ($col = 1; $col <= $nombreColonnes; $col++) {
    $typeDonnee = $_POST["typeDonnee".$col];
    $typesDonnees[$col] = $typeDonnee;
  }
  // Variables pour les fonctionnalités sélectionnées
  $fonctionnalitesEnTete = "";
  $fonctionnalitesColonne = "";
  $fonctionnalitesLigne = "";

  // Ajouter les fonctionnalités sélectionnées à leurs variables respectives
  if ($ET_Searchable) {
    $fonctionnalitesEnTete .= " Recherche";
  }
  if ($ET_Action) {
    $fonctionnalitesEnTete .= " Actions globales (dont export)";
  }
  if ($ET_Pagination) {
    $fonctionnalitesEnTete .= " Pagination";
  }
  if ($Col_fix) {
    $fonctionnalitesColonne .= " Colonne Fixe";
  }
  if ($Col_filtre) {
    $fonctionnalitesColonne .= " Colonne Filtrable";
  }
  if ($Col_action) {
    $fonctionnalitesColonne .= " Colonne Action";
  }
  if ($Lig_depliable) {
    $fonctionnalitesLigne .= " Ligne dépliable";
  }
  if ($Lig_select) {
    $fonctionnalitesLigne .= " Ligne Sélectionnable";
  }

  // Variables pour les positions des fonctionnalités

  // Générer le code HTML du tableau avec les fonctionnalités sélectionnées et leurs positions
  $tableHTML = "<table class='rcn-table'>\n";
  $tableHTML .= "<thead class='rcn-tableRow'>\n";
  $tableHTML .= "<tr class='rcn-tableRow__head'>\n";
  for ($col = 1; $col <= $nombreColonnes; $col++) {
    $colHeader = "Colonne $col";

    // Ajouter les fonctionnalités sélectionnées aux en-têtes de colonne
    if ($Col_fix) {
      if ($Col_fix && $col === 1) {
        $colHeader .= " (Fixe - Première)";
      }
      if ($Col_fix && $col === $nombreColonnes ) {
        $colHeader .= " (Fixe - Dernière)";
      }
    }
    if ($Col_action && $Col_fix && $col === $nombreColonnes) {
      $colHeader .= " (Action)";
    }
    if($Col_filtre) {
      $FiltrableCol = "<button class='rcn-icon rcn-iconButton rcn-icon--mdi-filter'>
                        <span class=''>Filtrer</span>
                      </button>";
    }else{
      $FiltrableCol = "<button class='rcn-icon rcn-iconButton rcn-icon--mdi-filter'>
                        <span class='sr-only'>Filtrer</span>
                      </button>";
    }

    $tableHTML .= "<th class='rcn-tableHead' scope='col' aria-sort=''>
                    <div class='rcn-tableHead__container'>
                      <span class=''>$colHeader</span>
                      $FiltrableCol
                    </div>
                  </th>\n";
  }
  $tableHTML .= "</tr>\n";
  $tableHTML .= "</thead>\n";
  $tableHTML .= "<tbody class='rcn-tableRow'>\n";
  for ($row = 1; $row <= $nombreLignes; $row++) {
    $tableHTML .= "<tr class='rcn-tableRow__cell'>\n";
    for ($col = 1; $col <= $nombreColonnes; $col++) {
      $rowData = "Ligne $row, Colonne $col";
  
      // Récupérer le type de donnée pour cette colonne
      $typeDonnee = $typesDonnees[$col];
  
      // Ajouter les fonctionnalités en fonction du type de donnée sélectionné
      switch ($typeDonnee) {
        case "texte":
          // Aucune fonctionnalité supplémentaire pour le texte
          $rowData = "<div class='rcn-tableCell__texte'>$rowData</div>";
          break;
        case "nombre":
          $rowData .= " (Nombre)";
          $rowData = "<div class='rcn-tableCell__number'>$rowData</div>";
          break;
        case "lien":
          $rowData .= " (Lien)";
          $rowData = "<div class='rcn-tableCell__link'>$rowData</div>";
          break;
        case "icone":
          $rowData .= " (Icône)";
          $rowData = "<div class='rcn-tableCell__icon'> texte avec de la longeueuru lorem ipsum $rowData</div>";
          break;
        case "bouton_selection":
          $rowData .= " (Bouton de sélection)";
          $rowData = "<div class='rcn-tableCell__select'><input type='checkbox' class='rcn-input--checkbox'></div>";
          break;
        case "bouton_depliable":
          $rowData .= " (Bouton dépliable)";
          $rowData = "<div class='rcn-tableCell__unfold'>$rowData</div>";
          break;
        case "bouton_action":
          $rowData .= " (Bouton d'action)";
          $rowData = "<div class='rcn-tableCell__action'><button class='rcn-button rcn-button--primary'>hola</button></div>";
          break;
      }
      if (!$typeDonnee) {
        $rowData = "<div class='rcn-tableCell__texte'>$rowData</div>";
      }
  
      $tableHTML .= "<td class='rcn-tableCell'>$rowData</td>\n";
    }
    $tableHTML .= "</tr>\n";
  }
  $tableHTML .= "</tbody>\n";
  $tableHTML .= "</table>\n";

  // Construire l'entête en fonction des éléments cochés
  $enteteTableau = '';
  if($ET_Searchable || $ET_Action || $ET_Pagination) {
    // Add Search
    if($ET_Searchable) {
      $enteteTableau .= '
      <div id="tableRecherche" class="rcn-preTable__search ">
					<form action="" role="search">
            <label class="rcn-inputFieldBloc__label sr-only">Search and reset</label>
            <div class="rcn-inputField">
                <input placeholder="Rechercher..." class="rcn-inputField__input">
                <button class="rcn-icon rcn-iconButton rcn-inputField__button rcn-inputField__button--secondary rcn-inputField__button--reset">
                    <span class="sr-only"></span>
                </button>
                <div class="rcn-inputField__buttonSeparator"></div>
                <button class="rcn-icon rcn-iconButton rcn-inputField__button rcn-inputField__button--search">
                    <span class="sr-only"></span>
                </button>
            </div>
					</form>
				</div>
      ';
    }
    // Add Action
    if($ET_Action) {
      $enteteTableau .= '
        <div class="rcn-preTable__ActionGlob">
					<button class="rcn-button rcn-button--secondary" aria-controls="table" title="Réinitialiser les filtres et tri de toutes les colonnes" >
            <i class="mdi mdi-filter-remove" aria-hidden="true"></i>
            Réinitialiser les filtres
          </button>
					<button class="rcn-button rcn-button--primary" title="Exporter le tableau en format CSV" >
            <i class="rcn-icon rcn-icon--mdi-arrowCollapseDown" aria-hidden="true"></i>
            Exporter le tableau
          </button>
        </div>
      '; 
    }

  }


  // Construire le résultat final avec les fonctionnalités sélectionnées
  $resultat = "<h2>Résultat du tableau :</h2>\n";
  $resultat .= "<p>Fonctionnalités de l'en-tête : $fonctionnalitesEnTete</p>\n";
  $resultat .= "<p>Fonctionnalités de colonne : $fonctionnalitesColonne</p>\n";
  $resultat .= "<p>Fonctionnalités de ligne : $fonctionnalitesLigne</p>\n";
  $resultat .= "<div class='rcn-tableContainer'>"; 
  $resultat .= "
  <div class='rcn-preTable'>
    <h1 id='TitreTable'>Tableau de donnée  - Général</h1> 
    <a title='Aller au pied du tableau' id='#RetourHTable' href='#RetourBTable'>
      Lien bas du tableau 
      <i class='rcn-icon rcn-icon--mdi-arrow-down'></i>
    </a>
  </div>
  ";
  if($ET_Searchable || $ET_Action || $ET_Pagination) {
    $resultat .= "
    <div class='rcn-preTable__action'>
      $enteteTableau
    </div>
    ";
  }
  $resultat .= $tableHTML;
  $resultat .= "
  <div id='RetourBTable'>
    <a title='Retour en haut du tableau' href='#RetourHTable'>Aller au sommet du tableau 
      <i class='rcn-icon rcn-icon--mdi-arrow-up'></i>
    </a>
  </div>";
  $resultat .= "</div>";

  // Enregistrer le résultat dans un fichier
  file_put_contents("tableau.html", $resultat);
}

?>

<!-- Rediriger vers la page principale après le traitement du formulaire -->
<script>
  window.location.href = "index.php";
</script>
