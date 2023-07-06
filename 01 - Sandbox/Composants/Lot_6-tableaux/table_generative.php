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
  $colonneFixePremiere = isset($_POST["Col_fix_premiere"]);
  $colonneFixeDerniere = isset($_POST["Col_fix_derniere"]);
  $colonneActionDerniere = isset($_POST["Col_action_derniere"]);

  // Générer le code HTML du tableau avec les fonctionnalités sélectionnées et leurs positions
  $tableHTML = "<table>\n";
  $tableHTML .= "<thead>\n";
  $tableHTML .= "<tr>\n";
  for ($col = 1; $col <= $nombreColonnes; $col++) {
    $colHeader = "Colonne $col";

    // Ajouter les fonctionnalités sélectionnées aux en-têtes de colonne
    if ($Col_fix) {
      if ($colonneFixePremiere && $col === 1) {
        $colHeader .= " (Fixe - Première)";
      }
      if ($colonneFixeDerniere && $col === $nombreColonnes) {
        $colHeader .= " (Fixe - Dernière)";
      }
    }
    if ($Col_action && $colonneActionDerniere && $col === $nombreColonnes) {
      $colHeader .= " (Action)";
    }

    $tableHTML .= "<th>$colHeader</th>\n";
  }
  $tableHTML .= "</tr>\n";
  $tableHTML .= "</thead>\n";
  $tableHTML .= "<tbody>\n";
  for ($row = 1; $row <= $nombreLignes; $row++) {
    $tableHTML .= "<tr>\n";
    for ($col = 1; $col <= $nombreColonnes; $col++) {
      $rowData = "Ligne $row, Colonne $col";

      // Ajouter les fonctionnalités sélectionnées aux données de la cellule
      if ($Lig_depliable) {
        $rowData .= " (Dépliable)";
      }
      if ($Lig_select) {
        $rowData .= " (Sélectionnable)";
      }

      $tableHTML .= "<td>$rowData</td>\n";
    }
    $tableHTML .= "</tr>\n";
  }
  $tableHTML .= "</tbody>\n";
  $tableHTML .= "</table>\n";

  // Construire le résultat final avec les fonctionnalités sélectionnées
  $resultat = "<h2>Résultat du tableau :</h2>\n";
  $resultat .= "<p>Fonctionnalités de l'en-tête : $fonctionnalitesEnTete</p>\n";
  $resultat .= "<p>Fonctionnalités de colonne : $fonctionnalitesColonne</p>\n";
  $resultat .= "<p>Fonctionnalités de ligne : $fonctionnalitesLigne</p>\n";
  $resultat .= $tableHTML;

  // Enregistrer le résultat dans un fichier
  file_put_contents("tableau.html", $resultat);
}
?>

<!-- Rediriger vers la page principale après le traitement du formulaire -->
<script>
  window.location.href = "index.php";
</script>
