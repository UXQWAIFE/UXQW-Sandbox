<?php
  session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  print_r($_SESSION);
  // Récupérer les données du formulaire
  $nombreColonnes = $_POST["nombreColonnes"];
  $nombreLignes = $_POST["nombreLignes"];
  $Lig_depliable_nbr = $_POST["Lig_depliable_nbr"];
  $Col_Fix_nbr = $_POST['Col_Fix_nbr'];
  
  // Récupérer les options des fonctionnalités
  $ET_Searchable = isset($_POST["ET_Searchable"]);
  $ET_Action = isset($_POST["ET_Action"]);
  $ET_Pagination = isset($_POST["ET_Pagination"]);
  $Col_fix = isset($_POST["Col_fix"]);
  $Col_filtre = isset($_POST["Col_filtre"]);
  $Col_action = isset($_POST["Col_action"]);
  $Col_action_menu = isset($_POST["Col_action_menu"]);
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
  $_SESSION['Col_action_menu'] = $Col_action_menu;
  $_SESSION['Lig_depliable'] = $Lig_depliable;
  $_SESSION['Lig_depliable_nbr'] = $Lig_depliable_nbr;
  $_SESSION['Lig_select'] = $Lig_select;
  
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
  $tableHTML = "<div class='rcn-tableContent'>\n";
  $tableHTML .= "<table class='rcn-table'>\n";
  $tableHTML .= "<thead class='rcn-tableRow'>\n";
  $tableHTML .= "<tr class='rcn-tableRow__head'>\n";
  
  for ($col = 1; $col <= $nombreColonnes; $col++) {
    $colHeader = "Colonne $col";
    $classThead = ' rcn-tableHead';

     

    // Ajouter les fonctionnalités sélectionnées aux en-têtes de colonne
    if ($Col_action && $Col_fix && $col === $nombreColonnes) {
      $colHeader .= " (Action)";
    }
    if($Col_filtre) {
      
      $FiltrableCol = "<div class='rcn-tableHead__container--filter'>
                        <button class=' rcn-icon rcn-iconButton rcn-icon--mdi-filter'>
                          <span class=''>Filtrer</span>
                        </button>
                      </div>
                      ";
    }else{
      $FiltrableCol = "<button class='rcn-icon rcn-iconButton rcn-icon--mdi-sort-descending'>
                        <span class='sr-only'>Filtrer</span>
                      </button>";
    }
    
    if ($Col_fix) {
      if ( $col < $Col_Fix_nbr ) {
        $colHeader .= " (Fixe - Première)";
        $classThead .= ' rcn-tableData--sticked';
      }

      if ( $col == $nombreColonnes ) {
        $colHeader .= " (Fixe - Dernière)";
        $classThead .= ' rcn-tableData--sticked';
      }
    }
    if($Lig_depliable || $Lig_select) {
      
      $typeDonnee = $typesDonnees[$col];

      $modifierThContainer = '';
      // Ajouter les fonctionnalités en fonction du type de donnée sélectionné
      switch ($typeDonnee) {
        case 'bouton_depliable':
          $colHeader = '<p class="sr-only">Déplier</p>';
          $FiltrableCol = '';
          $classThead .= ' rcn-tableHead--action';          
          $modifierThContainer .= 'rcn-tableHead__container--foldable';
        break;
        case 'bouton_selection':
          $colHeader = "
            <input type='checkbox' class='rcn-icon rcn-inputField__input rcn-inputField__input--checkbox'>
          ";
          $FiltrableCol = '';
          $classThead .= ' rcn-tableHead--action';
          $modifierThContainer .= ' rcn-tableHead__container--checkable';
        break;
      }
    }
    
      $tableHTML .= "<th class='". $classThead ."' scope='col' aria-sort=''>
                  <div class='rcn-tableHead__container $modifierThContainer'>
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
      $tableHTML .= "<tr class='rcn-tableRow__cell rcn-tableRow__cell--folded'>\n ";
      $folded = 2;
    } else if ($row > 1 && $row <= $Lig_depliable_nbr + 1) {
      $tableHTML .= "<tr class='rcn-tableSubRow__cell rcn-tableSubRow__cell--folded sr-only'>\n";
      $folded = 1;
    } else {
      $tableHTML .= "<tr class='rcn-tableRow__cell'>\n";
      $folded = 0;
    }
      for ($col = 1; $col <= $nombreColonnes; $col++) {
        $rowData = "Ligne $row, Colonne $col";
        $stickedClass = "";
        if($Col_fix && ($col < $Col_Fix_nbr  || $col == $nombreColonnes)) {
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
            case "bouton_action--withMenu":
              $rowData .= " (Bouton d'action)";
              $rowData = "<div class='rcn-tableCell__action--withMenu'>

                            <button class='rcn-icon rcn-iconButton rcn-icon--mdi-dots-vertical' aria-controls='contextMenu-$row'>
                              <span class='sr-only'>Ouvrir le menu contextuel</span>
                            </button>";
              
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
    <div class='rcn-preTable__function'>
      $enteteTableau
    </div>
    ";
  }
  if($Lig_select) {
    $resultat .= '
    <div class="rcn-preTable__rowSelected sr-only" aria-hidden="false">
				<div class="rcn-preTable__rowSelected--count">
					<p aria-owns=""><span>1</span> Ligne(s) séléctionnée(s)</p>				</div>
				<div>
					<div class="rcn-preTable__rowSelected--action">
						<button class="rcn-button rcn-button--secondary" aria-controls="ID" title="Action sur les lignes Séléctionner">Bouton 1</button>
						<button class="rcn-button rcn-button--secondary" aria-controls="ID" title="Action sur les lignes Séléctionner">Bouton 2</button>
						<button class="rcn-button rcn-button--secondary" aria-controls="ID" title="Action sur les lignes Séléctionner">Bouton 3</button>
					</div>
				</div>
			</div>
    ';

  }
  // Injection du tableau
  $resultat .= $tableHTML;

  // Injection du footer 
  $resultat .= $footerPagination;
 // Gestion du menu de filtre de colonne
 $filterContainer = '
 <div class="rcn-tableFilter__content" aria-hidden="true">
   
   <form action="">
       <div class="rcn-tableFilter__order">
           <p>Trier</p>
           <label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio rcn-inputFieldBloc__label--checkboxOrRadio-has-input-checked">
               <input name="choix" type="radio" id="radio" class="rcn-icon rcn-inputField__input rcn-inputField__input--radio">
               Trier de A à Z
           </label>
           <label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio rcn-inputFieldBloc__label--checkboxOrRadio-has-input-checked">
               <input name="choix" type="radio" id="radio" class="rcn-icon rcn-inputField__input rcn-inputField__input--radio">
               Trier de Z à A
           </label>
       </div>
       <div class="rcn-tableFilter__filter">
           <p>Filtrer</p>
           <div class="rcn-inputField rcn-tableFilter__Search">

               <input placeholder="Rechercher..." class="rcn-inputField__input">

               <button class="rcn-icon rcn-iconButton rcn-inputField__button rcn-inputField__button--search">
                   <span class="sr-only"></span>
               </button>
           </div>
           <label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio">
               <input name="choix" type="checkbox" id="checkbox" class="rcn-icon rcn-inputField__input rcn-inputField__input--checkbox">
               Ville 2
           </label>
           <label class="rcn-inputFieldBloc__label rcn-inputFieldBloc__label--checkboxOrRadio">
               <input name="choix" type="checkbox" id="checkbox" class="rcn-icon rcn-inputField__input rcn-inputField__input--checkbox">
               Ville 2
           </label>
       </div>
       <button class="rcn-button rcn-button--primary" type="submit">Appliquer</button>
   </form>
 </div>';
  $sideFilter = '<div class="rcn-tableFilter" aria-hidden="true">
  <button  id="CloseTriMenu" class="rcn-iconButton rcn-tableFilter__closeMenu" title="Fermer le menu de filtre" aria-controls="#triMenu" onclick="toggle_visibility()">
    <i aria-hidden="true" class="rcn-icon rcn-icon--mdi-close"></i>
    <span class="">Fermer</span>
  </button>
  <div class="rcn-accordions">';
  for ($col = 1; $col <= $nombreColonnes; $col++) {
    $colHeader = "Colonne $col";
    $sideFilter .= "
      <button class='rcn-accordions__heading' aria-expanded='false'>
        Filtre/Tri $colHeader
        <div class='rcn-icon rcn-accordions__headingIcon'>
        </div>
      </button>
      
      <div class='rcn-accordions__content' hidden>
        $filterContainer
      </div>
    ";
  }
  $sideFilter .= '</div></div>';

  if($Col_fix) {
    $resultat .= $sideFilter;
  }
  if($Col_action_menu) {
    for ($row = 1; $row <= $nombreLignes; $row++) {
        $contextMenuContainer = "<div id='contextMenu-$row' class='rcn-contextMenu' aria-hidden='true'>
                                  <button class='rcn-contextMenu__close rcn-iconButton' >
                                    <i class='rcn-icon rcn-icon--mdi-close'></i>
                                    <p class='sr-only'>Fermer</p>
                                  </button>
                                  <ul class='rcn-contextMenu__list'>
                                    <li class='rcn-contextMenu__listItem'>
                                      <a class='rcn-contextMenu__link' href='#commande1'>Action 1</a>
                                    </li>
                                    <li class='rcn-contextMenu__listItem'>
                                      <a class='rcn-contextMenu__link' href='#commande1'>Action 1</a>
                                    </li>
                                    <li class='rcn-contextMenu__listItem'>
                                      <a class='rcn-contextMenu__link' href='#commande1'>Action 1</a>
                                    </li>
                                    <li class='rcn-contextMenu__listItem'>
                                      <a class='rcn-contextMenu__link' href='#commande1'>Action 1</a>
                                    </li>
                                  </ul>
                                  <button class='rcn-contextMenu__Delete'>Supprimer</button>
                                </div>";
    
        $resultat .= $contextMenuContainer;
      
    }
  }


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
