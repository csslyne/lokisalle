<?php
function executeRequete($req)
{
  global $mysqli;
  $resultat = $mysqli->query($req);
  if(!$resultat)
  {
    die("Erreur sur la requête sql.<br />Message : ". $mysqli->error . "<br />Code : " . $req);
  }
  return $resultat;
}
/*-_-_-_-_-_-_-_*/
function debug($var, $mode=1)
{
  echo '<div style="background: orange; padding: 5px; float: right;">';
  $trace = debug_backtrace();
  $trace = array_shift($trace);//Enleve le tableau dans le tableau
  echo "Debug demandé dans le fichier : $trace[file] à la ligne $trace[line]. <hr />";
  if($mode === 1)
  {
    echo "<pre>";print_r($var);echo "</pre>";
  }
  else
  {
    echo "<pre>";var_dump($var);echo "</pre>";
  }
  echo '</div>';
}

/*-_-_-_-_-_-_-_*/

//Vérification de la présence du membre dans la BDD

function connexionUtilisateur(){
  if(!isset($_SESSION['membre']))
  {
    return false;
  }
  else
  {
    return true;
  }
}


function connexionAdmin(){
  if(connexionUtilisateur() && $_SESSION['membre']['statut'] == 1)
  {
    return true;
  }
  else
  {
    return false;
  }
}


function creationDuPanier()
{
  if(!isset($_SESSION['panier']))
  {
    $_SESSION['panier'] = array();
    $_SESSION['panier']['id_produit'] = array();
    $_SESSION['panier']['titre'] = array();
    $_SESSION['panier']['date_arrivee'] = array();
    $_SESSION['panier']['date_depart'] = array();
    $_SESSION['panier']['id_salle'] = array();
    $_SESSION['panier']['id_promo'] = array();
    $_SESSION['panier']['prix'] = array();
    $_SESSION['panier']['etat'] = array();

  }
}

function ajouterProduitPanier($id_produit, $titre, $date_arrivee, $date_depart, $id_salle, $id_promo, $prix, $etat)
{
  creationDuPanier();
  $position_produit = array_search($id_produit, $_SESSION['panier']['id_produit']);
  /*
  if($position_produit !== false)
  {
    $_SESSION['panier']['quantite'][$position_produit] += $quantite;
  }
  else
  {*/
  $_SESSION['panier']['id_produit'][] = $id_produit;
  $_SESSION['panier']['titre'][] = $titre;
  $_SESSION['panier']['date_arrivee'][] = $date_arrivee;
  $_SESSION['panier']['date_depart'][] = $date_depart;
  $_SESSION['panier']['id_salle'][] = $id_salle;
  $_SESSION['panier']['id_promo'][] = $id_promo;
  $_SESSION['panier']['prix'][] = $prix;
  $_SESSION['panier']['etat'][] = $etat;


}

/*-_*/

function montantTotal()
{
  $total = 0;

  for($i = 0; $i<count($_SESSION['panier']['id_produit']); $i++)
  {
    $total += $_SESSION['panier']['id_produit'][$i] * $_SESSION['panier']['prix'][$i];
  }

  return round($total, 2);
}
/*-_*/

function retirerProduitDuPanier($id_produit_a_supprimer)
{
  $position_produit = array_search($id_produit_a_supprimer, $_SESSION['panier']['id_produit']);
  if($position_produit !== false)
  {
    array_splice($_SESSION['panier']['id_produit'], $position_produit, 1);
    array_splice($_SESSION['panier']['titre'], $position_produit, 1);
    array_splice($_SESSION['panier']['date_arrivee'], $position_produit, 1);
    array_splice($_SESSION['panier']['date_depart'], $position_produit, 1);
    array_splice($_SESSION['panier']['id_salle'], $position_produit, 1);
    array_splice($_SESSION['panier']['id_promo'], $position_produit, 1);
    array_splice($_SESSION['panier']['prix'], $position_produit, 1);


  }
}

?>
