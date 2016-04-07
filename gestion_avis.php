<?php
require_once("../inc/init.inc.php");
//Je restreins l'accès au personne connecté avec le statut administrateur
if(!connexionAdmin())
{
  header("location:../connexion.php");
  exit();
}
$contenu .= '<a href="?action=affichage">Affichage des avis</a><br /><br/><hr /><br />';

//Je gére la suppression des avis dans la Bdd.
if(isset($_GET['action']) && $_GET['action'] == "suppression")
{
  $resultat = executeRequete("SELECT * FROM avis WHERE id_avis='$_GET[id_avis]'");
  $produit_a_supprimer = $resultat->fetch_assoc();
  executeRequete("DELETE FROM avis WHERE id_avis=$_GET[id_avis]");
   $contenu .= '<div class="validation">Suppression du produit : ' . $_GET['id_avis'] .'</div>';
  $_GET['action'] = 'affichage';
}

if(isset($_GET['action']) && $_GET['action'] == "affichage" )
{
    $resultat = executeRequete("SELECT * FROM avis");
    $contenu .= '<h2>Affichage des avis<h2>';
    $contenu .= 'Nombre d\'avis(s) : ' . $resultat->num_rows;
    $contenu .= '<table border="2" cellpadding="5"><tr>';

	
	while($colonne = $resultat->fetch_field())
    {
      $contenu .= '<th>' .$colonne->name . '</th>';
    }		
    $contenu .= '<th>Suppression</th>';

    $contenu .= '</tr>';

    while($ligne = $resultat->fetch_assoc())
    {
      $contenu .= '<tr>';
      foreach($ligne as $indice => $information)
      {
        $contenu .= '<td>'.$information.'</td>';
      }
      $contenu .= '<td><a href="?action=suppression&id_avis='.$ligne['id_avis'] .'"><img src="../inc/img/supp.png" /></a></td>';
      $contenu .= '</tr>';
    }
    $contenu .= '</table><br /><br />';
}

//J'ajoute le header et le menu du site.
require_once("../inc/haut.inc.php");
require_once("../inc/menu.inc.php");
//J'ajoute la partie ou est stocké le contenu du site.
echo $contenu;

//J'ajoute le footer du site.
require_once("../inc/bas.inc.php");
?>
