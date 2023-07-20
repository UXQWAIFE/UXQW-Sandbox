<?php
  session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  print_r($_SESSION);
  // Récupérer les données du formulaire
  $nombreColonnes = $_POST["nombreColonnes"];
  $nombreLignes = $_POST["nombreLignes"];
  $Lig_depliable_nbr = $_POST["Lig_depliable_nbr"];
  
  // Récupérer les options des fonctionnalités
  $ET_Searchable = isset($_POST["ET_Searchable"]);
  $ET_Action = isset($_POST["ET_Action"]);
  $ET_Pagination = isset($_POST["ET_Pagination"]);
  $Col_fix = isset($_POST["Col_fix"]);
  $Col_filtre = isset($_POST["Col_filtre"]);
  $Col_action = isset($_POST["Col_action"]);
  $Lig_depliable = isset($_POST["Lig_depliable"]);
  $Lig_select = isset($_POST["Lig_select"]);
  
  // Enregistrer les valeurs dans la session
  $_SESSION['nombreColonnes'] = $nombreColonnes;
  $_SESSION['nombreLignes'] = $nombreLignes;
  $_SESSION['ET_Searchable'] = $ET_Searchable;
  $_SESSION['ET_Action'] = $ET_Action;
  $_SESSION['ET_Pagination'] = $ET_Pagination;
  $_SESSION['Col_fix'] = $Col_fix;
  $_SESSION['Col_filtre'] = $Col_filtre;
  $_SESSION['Col_action'] = $Col_action;
  $_SESSION['Lig_depliable'] = $Lig_depliable;
  $_SESSION['Lig_depliable_nbr'] = $Lig_depliable_nbr;
  $_SESSION['Lig_select'] = $Lig_select;
  
  // Tableau de correspondance des types de données par colonne
  $typesDonnees = [];
 

  for ($col = 1; $col <= $nombreColonnes; $col++) {
    $typeDonnee = $_POST["typeDonnee".$col];
    $typesDonnees[$col] = $typeDonnee;
    $_SESSION['typesDonnee'][$col] = $typesDonnees[$col];
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
  $tableHTML = "<div class='rcn-tableContent'>\n";
  $tableHTML .= "<table class='rcn-table'>\n";
  $tableHTML .= "<thead class='rcn-tableRow'>\n";
  $tableHTML .= "<tr class='rcn-tableRow__head'>\n";
  
  for ($col = 1; $col <= $nombreColonnes; $col++) {
    $colHeader = "Colonne $col";

    // Ajouter les fonctionnalités sélectionnées aux en-têtes de colonne
    if ($Col_action && $Col_fix && $col === $nombreColonnes) {
      $colHeader .= " (Action)";
      $classThead = 'rcn-tableHead';
    }
    if($Col_filtre) {
      $FiltrableCol = "<button class='rcn-icon rcn-iconButton rcn-icon--mdi-filter'>
                        <span class=''>Filtrer</span>
                      </button>";
      $classThead = 'rcn-tableHead';
    }else{
      $FiltrableCol = "<button class='rcn-icon rcn-iconButton rcn-icon--mdi-filter'>
                        <span class='sr-only'>Filtrer</span>
                      </button>";
      $classThead = 'rcn-tableHeads';
    }
    
    if ($Col_fix) {
      if ($Col_fix && $col === 1) {
        $colHeader .= " (Fixe - Première)";
        $classThead = 'rcn-tableHead rcn-tableHead--action rcn-tableData--sticked';
      }
      if ($Col_fix && $col == $nombreColonnes ) {
        $colHeader .= " (Fixe - Dernière)";
        $classThead = "rcn-tableHead rcn-tableHead--action rcn-tableData--sticked";
      }
    }


    $tableHTML .= "<th class='". $classThead ."' scope='col' aria-sort=''>
                    <div class='rcn-tableHead__container'>
                      <span class=''>$colHeader</span>
                      $FiltrableCol
                    </div>
                  </th>\n";
  }
  $tableHTML .= "</tr>\n";
  $tableHTML .= "</thead>\n";
  $tableHTML .= "<tbody class='rcn-tableRow'>\n";
  if($Lig_depliable && isset($Lig_depliable_nbr)) {

    $Lig_depliable_nbrVal = $_POST['Lig_depliable_nbr'];
    $nombreLignes = $nombreLignes + $Lig_depliable_nbr;
  }
  for ($row = 1; $row <= $nombreLignes; $row++) {
    $foldedRow ='';
    if ($row === 1) {
      $tableHTML .= "<tr class='rcn-tableRow__cell rcn-tableRow__cell--fold'>\n ";
      $folded = 2;
    } else if ($row > 1 && $row <= $Lig_depliable_nbr + 1) {
      $tableHTML .= "<tr class='rcn-tableRow__cell rcn-tableRow__cell--folded sr-only'>\n";
      $folded = 1;
    } else {
      $tableHTML .= "<tr class='rcn-tableRow__cell'>\n";
      $folded = 0;
    }
      for ($col = 1; $col <= $nombreColonnes; $col++) {
        $rowData = "Ligne $row, Colonne $col";
        $stickedClass = "";
        if($Col_fix && ($col === 1 || $col == $nombreColonnes)) {
          $stickedClass .= "rcn-tableData--sticked";
        }
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
            $rowData = "<div class='rcn-tableCell__select'><input type='checkbox' class='rcn-icon rcn-inputField__input rcn-inputField__input--checkbox'></div>";
            break;
          case "bouton_depliable":
            $rowData .= " (Bouton dépliable)";
            if($folded === 1){
              $rowData = "";
            }else if ($folded === 2){
              $rowData = "<div class='rcn-tableCell__unfold'><button id='Lig_depliable' class='rcn-iconButton rcn-icon rcn-icon--mdi-chevron-down'></button></div>";
            }else{
              $rowData = "<div class='rcn-tableCell__unfold'><button class='rcn-iconButton rcn-icon rcn-icon--mdi-chevron-down'></button></div>";
            }
            break;
          case "bouton_action":
            $rowData .= " (Bouton d'action)";
            $rowData = "<div class='rcn-tableCell__action'><button class='rcn-button rcn-button--primary'>hola</button></div>";
            break;
        }
        if (!$typeDonnee) {
          $rowData = "<div class='rcn-tableCell__texte'>$rowData</div>";
        }
        $tableHTML .= "<td class='rcn-tableCell ". $stickedClass ." '>$rowData</td>\n";
      }
    
    $tableHTML .= "</tr>\n";
  }
  $tableHTML .= "</tbody>\n";
  $tableHTML .= "</table>\n";
  $tableHTML .= "</div>\n";

  // Construire en fonction des éléments cochés
  $enteteTableau = '';
  $footerTableau = '';

  if($ET_Searchable || $ET_Action || $ET_Pagination) {
   
    // Add Pagination
    if($ET_Pagination) {
      $enteteTableau .= '
      <p class="rcn-preTable__paginationTop" aria-live="polite">
        <span>1-3</span>
        sur 
        <span>32</span>
        <span>entités</span> 
        affichées
      </p>
      ';
      $footerPagination = '
        <div class="rcn-pagination__navLine">
          <div>
              1-4 sur 23 résultats
          </div>
          <nav>
              <ol class="rcn-pagination__navList">
                  <li>
                      <a title="Retour à la page précédente " class="rcn-link rcn-pagination__navLinks" href="#">
                          <i class="rcn-icon rcn-pagination__previousIcon"></i>
                          Précédent
                      </a>
                  </li>
                  <li>
                      <a aria-current="page" class="rcn-link rcn-pagination__navLinks" title="Naviguer à la page 1" href="#">1</a>
                  </li>
                  <li>
                      <a title="Naviguer à la page 2" class="rcn-link rcn-pagination__navLinks" href="#">2</a>
                  </li>
                  <li>
                      <p>...</p>
                  </li>
                  <li>
                      <a title="Naviguer à la page 4" class="rcn-link rcn-pagination__navLinks" href="#">4</a>
                  </li>
                  <li>
                      <a title="Naviguer à la page 5" class="rcn-link rcn-pagination__navLinks" href="#">5</a>
                  </li>
                  <li>
                      <a title="Aller à la page suivante" href="#" class="rcn-link rcn-pagination__navLinks"> 
                          Suivant 
                          <i class="rcn-icon rcn-pagination_nextIcon">
                          </i>
                      </a>
                  </li>
              </ol>
          </nav>
          <div class="rcn-inputFieldBloc rcn-inputFieldBloc--horizontal">        
              <label for="goToPage" class="rcn-inputFieldBloc__label rcn-pagination__label">Aller à la page</label>
              <div class="rcn-inputField">
                  <select name="goToPage" class="rcn-inputField__input rcn-inputField__input--select">
                      <option class="rcn-inputField__option" value="">1</option>
                      <option class="rcn-inputField__option" value="">2</option>
                      <option class="rcn-inputField__option" value="">3</option>
                      <option class="rcn-inputField__option" value="">4</option>
                      <option class="rcn-inputField__option" value="">5</option>
                  </select>
                  <button type="submit" class="rcn-iconButton rcn-icon rcn-pagination__goToPageButton"></button>
              </div>
          </div>

      </div>
      ';
    }
    if ($ET_Action || $ET_Searchable) {
      $zoneAction = '';
      // Add Action
      if($ET_Action) {
        $zoneAction .= '
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
      
      // Add Search
      if($ET_Searchable) {
        $zoneAction .= '
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
    }
    $enteteTableau .= '<div class="rcn-preTable__zoneAction">'. $zoneAction .'</div>';
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
      Aller au bas du tableau 
      <i class='rcn-icon rcn-icon--mdi-arrow-down'></i>
    </a>
  </div>
  ";
  if($ET_Searchable || $ET_Action ) {
    $resultat .= "
    <div class='rcn-preTable__fontcionnalite'>
      $enteteTableau
    </div>
    ";
  }
  // Injection du tableau
  $resultat .= $tableHTML;

  // Injection du footer 
  $resultat .= $footerPagination;
  $resultat .= "
  <div id='RetourBTable' class='rcn-postTable'>
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
