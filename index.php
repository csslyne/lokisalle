<?php 
//********* Include *********//

require_once("inc/init.inc.php");

//********* Texte de présentation *********//

$contenu .= '<div><p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p></div><br /><br />';

//********* Selection des informations concernant les salles *********//

$salle = executeRequete(" SELECT p.date_arrivee, p.date_depart, p.prix, s.photo, s.ville, s.capacite, s.id_salle, p.id_produit
 FROM salle s, produit p
 WHERE p.date_arrivee > CURDATE()
 AND s.id_salle = p.id_salle
 AND p.etat = 0
 ORDER BY p.id_produit DESC LIMIT 0,3");
$contenu .= '<h2>Nos trois dernière offres :<h2><br /><br />';

//********* Affichage des informations concernant les salles *********//

while($ligne_salle = $salle->fetch_assoc())
{
  $contenu .= '<div>';
  $contenu .= '<img src="'.$ligne_salle['photo'].'" alt="" height="200" width="300">';
  $contenu .= '<p>'.$ligne_salle['date_arrivee'].'</p>';
  $contenu .= '<p>' .$ligne_salle['date_depart'].'</p>';
  $contenu .= '<p>' .$ligne_salle['ville'].'</p>';
  $contenu .= '<p>' .$ligne_salle['prix'].'</p>';
  $contenu .= '<p>' .$ligne_salle['capacite'].'</p>';

  $contenu .= '<a href="reservation_details.php?id_salle='.$ligne_salle['id_salle'].'">Voir la fiche détaillée</a>';

  if(connexionUtilisateur())
  {

    $contenu .= '<form method="post" action="panier.php">';
    $contenu .= "<input type='hidden' name='id_produit' value='$ligne_salle[id_produit]' />";

    $contenu .= '<input type="submit" name="ajout_au_panier" value="Ajout au panier" />';
    $contenu .= '</form>';
  }else{
    $contenu .= '<a href="connexion.php?id_produit='.$ligne_salle['id_produit'].'">Connectez vous pour l\'ajouter au panier</a>';  
  }

  $contenu .= '</div>';
}

require_once("inc/haut.inc.php");
require_once("inc/menu.inc.php");
echo $contenu;
require_once("inc/bas.inc.php"); 
?>
