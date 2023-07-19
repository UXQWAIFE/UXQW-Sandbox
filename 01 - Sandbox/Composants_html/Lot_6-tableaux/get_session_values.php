<?php
session_start();

// Récupérer les valeurs de $_SESSION
$sessionValues = array();
$nombreColonnes = $_SESSION['nombreColonnes'];
for ($col = 1; $col <= $nombreColonnes; $col++) {
  $sessionValues[$col] = isset($_SESSION['typesDonnee'][$col]) ? $_SESSION['typesDonnee'][$col] : "";
}

// Renvoyer les valeurs en tant que réponse JSON
header('Content-Type: application/json');
echo json_encode($sessionValues);
?>
