<?php

require_once("../inc/init.inc.php");

//Je restreins l'accès au personne connecté avec le statut administrateur
if(!connexionAdmin())
{
  header("location:../connexion.php");
  exit();
}

//Bouton Ajouter
$contenu .= '<a href="?action=ajout&order=prix">Ajouter un produit</a><br />';
//Bouton Affichage
$contenu .= '<a href="?action=affichage&order=prix">Affichage des produits</a><br /><br/><hr /><br />';

//Je gére la suppression des produits dans la Bdd.
if(isset($_GET['action']) && $_GET['action'] == "suppression")
{
  $resultat = executeRequete("SELECT * FROM produit WHERE id_produit='$_GET[id_produit]'");
  $produit_a_supprimer = $resultat->fetch_assoc();
  executeRequete("DELETE FROM produit WHERE id_produit=$_GET[id_produit]");
  $contenu .= '<div class="validation">Suppression du produit : ' . $_GET['id_produit'] .'</div>';
  $_GET['action'] = 'affichage';
}

//Je crée des variables pour le tri des champs de la base produit

$tri_autorises = array('date_arrivee', 'date_depart', 'id_salle','id_promo','prix');
$order_by = in_array($_GET['order'],$tri_autorises) ? $_GET['order'] : 'prix';
// Sens du tri
$order_dir = isset($_GET['inverse']) ? 'DESC' : 'ASC';

if(isset($_GET['action']) && $_GET['action'] && $_GET['action'] == "affichage" ){
  // Préparation de la requête
  $result = executeRequete("SELECT * FROM produit ORDER BY {$order_by} {$order_dir}");
  $contenu .= '<h2>Affichage des produits<h2>';
  $contenu .= 'Nombre de produit(s) : '. $result->num_rows;
  $contenu .= '<table border="2" cellpadding="5"><tr>';
  // Notre fonction qui affiche les liens
  function sort_link($text, $order=false)
  {
    global $order_by, $order_dir;

    if(!$order)
      $order = $text;
    $link = '<a href="?action=affichage&order=' . $order;
    if($order_by==$order && $order_dir=='ASC')
      $link .= '&inverse=true';
    $link .= '"';
    if($order_by==$order && $order_dir=='ASC')
      $link .= ' class="order_asc"';
    elseif($order_by==$order && $order_dir=='DESC')
      $link .= ' class="order_desc"';
    $link .= '>' . $text . '</a>';

    return $link;
  }
  $contenu .= '<table border="2" cellpadding="5" id="table">';
  $contenu .= '<tr>';
  $contenu .= '<th>'.sort_link('Date arrivee', 'date_arrivee').'</th>';
  $contenu .= '<th>'.sort_link('Date depart', 'date_depart').'</th>';
  $contenu .= '<th>'.sort_link('Salle', 'id_salle').'</th>';
  $contenu .= '<th>'.sort_link('Promo', 'id_promo').'</th>';
  $contenu .= '<th>'.sort_link('Prix', 'prix').'</th>';
  $contenu .= '<th>Modification</th>';
  $contenu .= '<th>Suppression</th>';
  $contenu .= '</tr>';

  while($row = $result->fetch_assoc()){
    $contenu .= '<tr>';
    $contenu .= '<td>'.$row['date_arrivee'].'</td>';
    $contenu .= '<td>'.$row['date_depart'].'</td>';
    $contenu .= '<td>'.$row['id_salle'].'</td>';
    $contenu .= '<td>'.$row['id_promo'].'</td>';
    $contenu .= '<td>'.$row['prix'].'</td>';
    $contenu .= '<td><a href="?action=modification&order=prix&id_produit='.$row['id_produit'] .'"><img src="../inc/img/modif.png" /></a></td>';
    $contenu .= '<td><a href="?action=suppression&order=prix&id_produit='.$row['id_produit'] .'"><img src="../inc/img/supp.png" /></a></td>';
    $contenu .= '</tr>';	
  }
  $contenu .= '</table>';
}


//Je gére l'enregistrement des produits dans la bdd
if(!empty($_POST))
{
  $_POST['date_arrivee'] = str_replace('/', '-', $_POST['date_arrivee']);
  $_POST['date_depart'] = str_replace('/', '-', $_POST['date_depart']);
  //J'empêche les injections dans la base de données
  foreach($_POST as $indice => $valeur)
  {
    $_POST[$indice] = htmlentities(addSlashes($valeur));
  }

  if(isset($_GET['id_produit'])){
    executeRequete("UPDATE produit SET date_arrivee='$_POST[date_arrivee]', date_depart='$_POST[date_depart]',id_salle='$_POST[choix_salle]', id_promo='$_POST[choix_promo]', prix='$_POST[prix]' WHERE id_produit = $_POST[id_produit]");
  }else{
    executeRequete("INSERT INTO  produit(id_produit, date_arrivee, date_depart, id_salle, id_promo, prix) VALUES ('$_POST[id_produit]','$_POST[date_arrivee]', '$_POST[date_depart]', '$_POST[choix_salle]','$_POST[choix_promo]', '$_POST[prix]')");	
  }

}

//J'ajoute le header et le menu du site.
require_once("../inc/haut.inc.php");
require_once("../inc/menu.inc.php");
//J'ajoute la partie ou est stocké le contenu du site.
echo $contenu;

//Formulaire pour ajouter une salle.
//Dans les "value" je récupére les données des produits, pour les auto remplir dans le formulaire quand on souhaite modifier le produit. 
if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification'))
{
  if(isset($_GET['id_produit']))
  {
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit=$_GET[id_produit]");
    $produit_actuel = $resultat->fetch_assoc();
  }

  echo '
<h1>Ajouter un produit</h1><br />
<form method="post" action="">

<label for="choix_salle">Choisir une salle parmi les salles existantes :</label><br /><br />
<select name="choix_salle">';
  //requete pour la liste deroulante promotion
  $choix_salle = executeRequete("SELECT * FROM salle");
  while ($salle_donnees = $choix_salle -> fetch_assoc())
  {
    if($salle_donnees['id_salle'] == $produit_actuel['id_salle'])
      $selected = 'selected="selected"';
    else
      $selected = '';
    echo '<option value="'.$salle_donnees['id_salle']. ' - ' .$salle_donnees['pays']. ' - ' .$salle_donnees['ville']. ' - ' .$salle_donnees['adresse']. ' - ' .$salle_donnees['capacite']. ' - ' .$salle_donnees['categorie'].'" ' . $selected . '>'.$salle_donnees['id_salle']. ' - ' .$salle_donnees['pays']. ' - ' .$salle_donnees['ville']. ' - ' .$salle_donnees['adresse']. ' - ' .$salle_donnees['capacite']. ' - ' .$salle_donnees['categorie'].'</option>';
  }

  echo '</select><br /><br />

<input type="hidden" id="id_produit" name="id_produit" value="';if(isset($produit_actuel['id_produit'])) echo $produit_actuel['id_produit']; echo ' "/>

<label for="date_arrivee">Date d\'arrivée</label><br />
<input type="date" id="date_arrivee" name="date_arrivee" value="';if(isset($produit_actuel['date_arrivee'])) echo $produit_actuel['date_arrivee']; echo '"><br /><br />

<label for="date_depart">Date de départ</label><br />
<input type="date" id="date_depart" name="date_depart" value="';if(isset($produit_actuel['date_depart'])) echo $produit_actuel['date_depart']; echo '"/><br /><br />

<label for="choix_promo">Attribution remise parmi les codes promo existant : </label><br /><br />
<select name="choix_promo">';
  //requete pour la liste deroulante promotion
  $choix_promo = executeRequete("SELECT * FROM promotion");
  while ($promo_donnees = $choix_promo -> fetch_assoc())
  {
    if($promo_donnees['id_promo'] == $produit_actuel['id_promo'])
      $selected = 'selected="selected"';
    else
      $selected = '';
    echo '<option value="'.$promo_donnees['id_promo']. ' ' .$promo_donnees['code_promo']. ' '.$promo_donnees['reduction']. '" ' . $selected . '>'.$promo_donnees['id_promo']. ' ' . $promo_donnees['code_promo']. ' ' .$promo_donnees['reduction'].'</option>';
  }
  echo '</select><br /><br />

<label for="prix">Prix</label><br />
<input type="text" id="prix" name="prix" value="';if(isset($produit_actuel['prix'])) echo $produit_actuel ['prix']; echo '"/><br /><br />

<input type="submit" id="envoie" name="envoie" value="en faire un produit"/>

</form>';

}
//J'ajoute le footer du site.
require_once("../inc/bas.inc.php");
?>
