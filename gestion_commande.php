<?php
require_once("../inc/init.inc.php");
//Je restreins l'accès au personne connecté avec le statut administrateur
if(!connexionAdmin())
{
  header("location:../connexion.php");
  exit();
}

//Bouton Gestion des commandes
$contenu .= '<a href="?action=gestion&order&id_commande=montant">Gestion des commandes</a><br/><hr /><br />';

//Gestion du tri
$tri_autorises = array('id_commande', 'id_membre', 'montant');
$order_by = in_array($_GET['order'],$tri_autorises) ? $_GET['order'] : 'montant';
// Sens du tri
$order_dir = isset($_GET['inverse']) ? 'DESC' : 'ASC';

//Gestion des commandes
if(isset($_GET['action']) && $_GET['action'] && $_GET['action'] == "gestion" ){
// Préparation de la requête
$result = executeRequete("SELECT * FROM commande ORDER BY {$order_by} {$order_dir}");
		$contenu .= '<h2>Affichage des commandes<h2>';
    $contenu .= 'Nombre de commande(s) : '. $result->num_rows;
    $contenu .= '<table border="2" cellpadding="5"><tr>';

// Fonction qui affiche les liens
function sort_link($text, $order=false)
{
    global $order_by, $order_dir;

    if(!$order)
        $order = $text;
    $link = '<a href="?action=gestion&order&id_commande=' . $order;
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
$contenu .= '<th>'.sort_link('Commande', 'id_commande').'</th>';
$contenu .= '<th>'.sort_link('Membre', 'id_membre').'</th>';
$contenu .= '<th>'.sort_link('Montant', 'montant').'</th>';
$contenu .= '</tr>';

while($row = $result->fetch_assoc()){
	  $contenu .= '<tr>';
		$contenu .= '<td><a href="?action=gestion&order&id_commande='.$row['id_commande'].'">'.$row['id_commande'].'</a></td>';
		$contenu .= '<td>'.$row['id_membre'].'</td>';
		$contenu .= '<td>'.$row['montant'].'</td>';
    $contenu .= '</tr>';
}
$contenu .= '</table><br /><br />';
}

$chiffreAffaire = executeRequete("SELECT sum(montant) AS somme FROM commande");

while ($calcul = $chiffreAffaire->fetch_assoc()) {
      $contenu .= '<div>';
      $contenu .= 'Le Chiffre d’affaires (CA) de notre société est de : '. $calcul['somme']. ' €';
      $contenu .= '</div><br /><br />';
  }

  if(isset($_GET['action']) && ($_GET['action'] == 'gestion' || $_GET['action'] == 'order' && $_GET['action'] == 'id_commande'))
  {
    $resultat = executeRequete("SELECT c.id_commande, c.montant, c.date, m.id_membre, m.pseudo, p.id_produit, p.id_salle, s.ville
    FROM commande c, membre m, produit p, salle s, details_commande d
    WHERE c.id_commande = '$_GET[id_commande]'
    AND c.id_membre = m.id_membre
    AND p.id_produit = d.id_produit
    AND p.id_salle = s.id_salle
    AND c.id_commande = d.id_commande");

    $contenu .= '<h2>Affichage details des commandes :<h2>';
    $contenu .= '<table border="2" cellpadding="5">';

    while($colonne = $resultat->fetch_field())
      {
        $contenu .= '<th>' .$colonne->name . '</th>';
      }
    while($commande = $resultat->fetch_assoc())
    {
      $contenu .= '<tr>';
      $contenu .= '<td>'.$commande['id_commande'].'</td>';
      $contenu .= '<td>'.$commande['montant'].'</td>';
      $contenu .= '<td>'.$commande['date'].'</td>';
      $contenu .= '<td>'.$commande['id_membre'].'</td>';
      $contenu .= '<td>'.$commande['pseudo'].'</td>';
      $contenu .= '<td>'.$commande['id_produit'].'</td>';
      $contenu .= '<td>'.$commande['id_salle'].'</td>';
      $contenu .= '<td>'.$commande['ville'].'</td>';
      $contenu .= '</tr>';
    }
    $contenu .= '</table>';
}

//J'ajoute le header et le menu du site.
require_once("../inc/haut.inc.php");
require_once("../inc/menu.inc.php");
//J'ajoute la partie ou sont stocké le contenu du site.
echo $contenu;
//J'ajoute le footer
require_once("../inc/bas.inc.php");
?>
