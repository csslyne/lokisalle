<?php
require_once("../inc/init.inc.php");
//Je restreins l'accès au personne connecté avec le statut administrateur
if(!connexionAdmin())
{
  header("location:../connexion.php");
  exit();
}
//Je gére la suppression des salles de la Bdd.
if(isset($_GET['action']) && $_GET['action'] == "suppression")
{
  $resultat = executeRequete("SELECT * FROM salle WHERE id_salle='$_GET[id_salle]'");
  $salle_a_supprimer = $resultat->fetch_assoc();
  $chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . $salle_a_supprimer['photo'];//Chemin complet vers la photo à supprimer
  if(!empty($salle_a_supprimer['photo']) && file_exists($chemin_photo_a_supprimer))
  {
    unlink($chemin_photo_a_supprimer);
  }
  executeRequete("DELETE FROM salle WHERE id_salle=$_GET[id_salle]");
  $contenu .= '<div class="validation">Suppression du produit : ' . $_GET['id_salle'] .'</div>';
  $_GET['action'] = 'affichage';
}

//Je gére l'enregistrement des salles dans la bdd
if(!empty($_POST))
{
  //Définition d'une variable pour gérer l'enregistrement du chemin des photos dans la bdd.
  $photo_bdd = "";

  if(isset($_GET['action']) && $_GET['action'] == 'modification')
  {
    $photo_bdd = $_POST['photo_actuelle'];
  }
  if(!empty($_FILES['photo']['name']))
  {
    //Je renomme la photo 
    $nom_photo = $_POST['titre'].'_'.$_FILES['photo']['name']; 
    $photo_bdd = RACINE_SITE . "photo/$nom_photo";
    $photo_dossier = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . "/photo/$nom_photo";
    copy($_FILES['photo']['tmp_name'], $photo_dossier);
  }

  foreach($_POST as $indice => $valeur)
  {
    $_POST[$indice] = htmlentities(addSlashes($valeur));
  }


  if(isset($_GET['id_salle']))
  {
    executeRequete("UPDATE salle SET pays='$_POST[pays]', ville='$_POST[ville]', adresse='$_POST[adresse]', cp='$_POST[cp]', titre='$_POST[titre]', description='$_POST[description]', photo='$photo_bdd', capacite='$_POST[capacite]', categorie='$_POST[categorie]' WHERE id_salle = $_POST[id_salle]");
  }else{

    executeRequete("INSERT INTO salle (id_salle, pays, ville, adresse, cp, titre, description, photo, capacite, categorie) VALUE ('$_POST[id_salle]','$_POST[pays]','$_POST[ville]','$_POST[adresse]','$_POST[cp]','$_POST[titre]','$_POST[description]','$photo_bdd','$_POST[capacite]','$_POST[categorie]')");
    $_GET['action'] = 'affichage';  
  } 
}

//Bouton Ajouter
$contenu .= '<a href="?action=ajout">Ajouter une salle</a><br />';
//Bouton Affichage
$contenu .= '<a href="?action=affichage">Affichage des salles</a><br /><br/><hr /><br />';


//Je gére l'affichage des salles dans la bdd

if(isset($_GET['action']) && $_GET['action'] == "affichage" )
{
  $resultat = executeRequete("SELECT * FROM salle");
  $contenu .= '<h2>Affichage des salles<h2>';
  $contenu .= 'Nombre de salle(s) : ' . $resultat->num_rows;
  $contenu .= '<table border="2" cellpadding="5"><tr>';


  while($colonne = $resultat->fetch_field())
  {
    $contenu .= '<th>' .$colonne->name . '</th>';
  }

  $contenu .= '<th>Modification</th>';
  $contenu .= '<th>Suppression</th>';
  $contenu .= '</tr>';

  while($ligne = $resultat->fetch_assoc())
  {
    $contenu .= '<tr>';
    foreach($ligne as $indice => $information)
    {
      if($indice == "photo")
      {
        $contenu .= '<td><img src="'.$information.'" width="70" height="70" /></td>';
      }
      else
      {

        $contenu .= '<td>'.$information.'</td>';
      }
    }

    $contenu .= '<td><a href="?action=modification&id_salle='.$ligne['id_salle'] .'"><img src="../inc/img/modif.png" /></a></td>';
    $contenu .= '<td><a href="?action=suppression&id_salle='.$ligne['id_salle'] .'"><img src="../inc/img/supp.png" /></a></td>';
    $contenu .= '</tr>';
  }
  $contenu .= '</table><br /><hr /><br />';
}


//J'ajoute le header et le menu du site.
require_once("../inc/haut.inc.php");
require_once("../inc/menu.inc.php");
//J'ajoute la partie ou sont stocké le contenu du site.
echo $contenu;

//Formulaire pour ajouter une salle.
//Dans les "value" je récupére les données des salles, pour les auto remplir dans le formulaire quand on souhait modifier la salle. 
if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification'))
{
  if(isset($_GET['id_salle']))
  {
    $resultat = executeRequete("SELECT * FROM salle WHERE id_salle=$_GET[id_salle]");
    $salle_actuelle = $resultat->fetch_assoc();
  }

  echo '
<h1>Ajouter une salle</h1>
<form method="post" action="" enctype="multipart/form-data">

<input type="hidden" id="id_salle" name="id_salle" value="';if(isset($salle_actuelle['id_salle'])) echo $salle_actuelle ['id_salle']; echo ' "/>

<label for="pays">Pays</label><br />
<input type="text" id="pays" name="pays" value="';if(isset($salle_actuelle['pays'])) echo $salle_actuelle['pays']; echo '"/><br /><br />

<label for="ville">Ville</label><br />
<input type="text" id="ville" name="ville" value="';if(isset($salle_actuelle['ville'])) echo $salle_actuelle['ville']; echo '"/><br /><br />

<label for="adresse">Adresse</label><br />
<textarea id="adresse" name="adresse">';if(isset($salle_actuelle['adresse'])) echo $salle_actuelle['adresse']; echo '</textarea><br /><br />

<label for="cp">Code postal</label><br />
<input type="text" id="cp" name="cp" value="';if(isset($salle_actuelle['cp'])) echo $salle_actuelle['cp']; echo '"/><br /><br />

<label for="titre">Titre</label><br />
<input type="text" id="titre" name="titre" value="';if(isset($salle_actuelle['titre'])) echo $salle_actuelle['titre']; echo '"/><br /><br />

<label for="description">Description</label><br />
<textarea id="description" name="description">';if(isset($salle_actuelle['description'])) echo $salle_actuelle['description']; echo '</textarea><br /><br />

<label for="photo">Photo</label><br />
<input type="file" id="photo" name="photo"/><br /><br />';

  if(isset($salle_actuelle))
  {
    echo '<i>Vous pouvez uploader une nouvelle photo si vous souhaitez la changer</i>';
    echo '<img src="'.$salle_actuelle['photo'].'" width="90" height="90" /><br />';
    echo '<input type="hidden" name="photo_actuelle" value="'.$salle_actuelle['photo'].'" /><br />';
  }
  echo '

<label for="capacite">Capacite</label><br />
<input type="text" id="capacite" name="capacite" value="';if(isset($salle_actuelle['capacite'])) echo $salle_actuelle['capacite']; echo '"/><br /><br />

<label for="categorie">Catégorie</label><br />
<input type="radio" name="categorie" value="reunion"';if(isset($salle_actuelle) && $salle_actuelle['categorie'] == 'reunion') echo 'checked'; elseif(!isset($salle_actuelle) && !isset($_POST['categorie'])) echo 'checked'; echo ' />Reunion<br />
<input type="radio" name="categorie" value="conference" ';if(isset($salle_actuelle) && $salle_actuelle['categorie'] == 'conference') echo 'checked'; echo ' />Conférence<br />
<input type="radio" name="categorie" value="multimedia" ';if(isset($salle_actuelle) && $salle_actuelle['categorie'] == 'multimedia') echo 'checked'; echo ' />Multimedia<br /><br />

<input type="submit" id="ajouter" name="ajouter" value="'; echo ucfirst($_GET['action']).'"/><br />


</form>';
}
require_once("../inc/bas.inc.php");
?>
