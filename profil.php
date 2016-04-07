<?php 
require("inc/init.inc.php");

//********* Redirection *********//

if(!connexionUtilisateur())
{
    header("location:connexion.php");
}

//********* Affichage des informations du membre *********//

$contenu .= '<div class="cadre"><h2>Voici vos informations de profil </h2>';
$contenu .= '<p> Votre email est : ' . $_SESSION['membre']['pseudo'] . '<br />';
$contenu .= '<p> Votre email est : ' . $_SESSION['membre']['email'] . '<br />';
$contenu .= 'Votre ville est : ' . $_SESSION['membre']['ville'] . '<br />';
$contenu .= 'Votre code postal est : ' . $_SESSION['membre']['cp'] . '<br />';
$contenu .= 'Votre adresse est : ' . $_SESSION['membre']['adresse'] . '</p></div><br /><br />';

//********* Bouton modifier *********//

$contenu .= '<td><a href="?action=modification&id_membre='.$_SESSION['membre']['id_membre'] .'">Mettre à jour mes informations</a></td>';

//********* Modification des information du profil *********//

if(!empty($_POST))
{
    $hash_mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
    foreach($_POST as $indice => $valeur)
    {
        $_POST[$indice] = htmlentities(addSlashes($valeur));
    }
    executeRequete("REPLACE INTO membre(id_membre, pseudo, mdp, nom, prenom, email, sexe, ville, cp, adresse, statut) VALUES ('$_POST[id_membre]','$_POST[pseudo]', '$hash_mdp', '$_POST[nom]', '$_POST[prenom]','$_POST[email]', '$_POST[sexe]','$_POST[ville]', '$_POST[cp]','$_POST[adresse]','$_POST[statut]')");	
}

//********* Affichage html *********//

require_once("inc/haut.inc.php");
require_once("inc/menu.inc.php");
echo $contenu;

//********* Formulaire d'inscription avec les informations pré rempli en cas de modification d'information *********//

if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification'))
{

    if(isset($_GET['id_membre']))
    {
        $resultat = executeRequete("SELECT * FROM membre WHERE id_membre=$_GET[id_membre]");
        $membre_actuel = $resultat->fetch_assoc();
    }

    echo '
<form method="post" action="">

<input type="hidden" id="id_membre" name="id_membre" value="';if(isset($membre_actuel['id_membre'])) echo $membre_actuel ['id_membre']; echo ' "/>

<label for="pseudo">Pseudo* :</label><br />
<input type="text" name="pseudo" id="pseudo" value="';if(isset($membre_actuel['pseudo'])) echo $membre_actuel ['pseudo']; echo ' " /><br /><br />

<label for="nom">Nom* :</label><br />
<input type="text" name="nom" id="nom" value="';if(isset($membre_actuel['nom'])) echo $membre_actuel ['nom']; echo ' " /><br /><br />

<label for="prenom">Prénom* :</label><br />
<input type="text" name="prenom" id="prenom" value="';if(isset($membre_actuel['prenom'])) echo $membre_actuel ['prenom']; echo ' " /><br /><br />

<label for="email">Email* :</label><br />
<input type="email" name="email" id="email" value="';if(isset($membre_actuel['email'])) echo $membre_actuel ['email']; echo ' " /><br /><br />

<label for="sexe">Sexe* :</label><br />
<input type="radio" name="sexe" value="m"';if(isset($membre_actuel) && $membre_actuel['sexe'] == 'm') echo 'checked'; elseif(!isset($membre_actuel) && !isset($_POST['sexe'])) echo 'checked'; echo '/>Homme<br />
<input type="radio" name="sexe" value="f"';if(isset($membre_actuel) && $membre_actuel['sexe'] == 'f') echo 'checked'; echo '/>Femme<br /><br />

<label for="ville">Ville* :</label><br />
<input type="text" name="ville" id="ville" value="';if(isset($membre_actuel['ville'])) echo $membre_actuel ['ville']; echo ' " /><br /><br />

<label for="cp">Code postal* :</label><br />
<input type="text" name="cp" id="cp" value="';if(isset($membre_actuel['cp'])) echo $membre_actuel ['cp']; echo ' " /><br /><br />

<label for="adresse">Adresse* :</label><br />
<textarea name="adresse" id="adresse" >';if(isset($membre_actuel['adresse'])) echo $membre_actuel['adresse']; echo '</textarea><br /><br />

<input type="submit" id="valider" name="valider" value="valider"/>
</form>';
}
require_once("inc/bas.inc.php");
?>
