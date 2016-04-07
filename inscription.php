<?php 
require_once("inc/init.inc.php");

//********* Redirection *********//

if(connexionUtilisateur())
{
    header("location:profil.php");
}

//********* Recupération des données du formulaire d'inscription *********//

if($_POST)
{
    //Verifier les caractéres autorisé dans les champs  : 
    $verif_caractere = '#^[a-zA-Z0-9._-]+$#';
    $verif_email='#^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,}$#';
    $verif_cp = '#^[0-9]+$#';
    $verif_adresse = '#^[a-zA-Z0-9. _-]+$#';
    //cryptage du mot de passe
    $hash_mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);

    if(!preg_match($verif_caractere, $_POST['pseudo']) || (strlen($_POST['pseudo']) < 1 || strlen($_POST['pseudo']) > 15) ){
        $contenu .= "<div class='erreur'>Le pseudo doit contenir entre 1 et 15 Caractéres. <br />Caractéres acceptés : Lettre de A à Z et chiffre de 0 à 9</div>"; 
    }
    if(!preg_match($verif_caractere, $_POST['mdp']) || (strlen($_POST['mdp']) < 1 || strlen($_POST['mdp']) > 15) ){
        $contenu .= "<div class='erreur'>Le mot de passe doit contenir entre 1 et 15 Caractéres. <br />Caractéres acceptés : Lettre de A à Z et chiffre de 0 à 9</div>"; 
    }
    if(!preg_match($verif_caractere, $_POST['nom']) || (strlen($_POST['nom']) < 1 || strlen($_POST['nom']) > 20) ){
        $contenu .= "<div class='erreur'>Le nom doit contenir entre 1 et 20 Caractéres. <br />Caractéres acceptés : Lettre de A à Z et chiffre de 0 à 9</div>"; 
    }
    if(!preg_match($verif_caractere, $_POST['prenom']) || (strlen($_POST['prenom']) < 1 || strlen($_POST['prenom']) > 20) ){
        $contenu .= "<div class='erreur'>Le prenom doit contenir entre 1 et 20 Caractéres. <br />Caractéres acceptés : Lettre de A à Z et chiffre de 0 à 9</div>"; 
    }	 
    if(!preg_match($verif_email, $_POST['email'])){
        $contenu .= "<div class='erreur'>L'email doit contenir un @ et une extension</div>"; 
    }
    if(empty($_POST['sexe'])){
        $contenu .= "<div class='erreur'>Veuillez préciser votre sexe</div>"; 
    }
    if(!preg_match($verif_adresse , $_POST['ville']) || (strlen($_POST['ville']) < 1 || strlen($_POST['ville']) > 20) ){
        $contenu .= "<div class='erreur'>La ville doit contenir entre 1 et 20 caractères. <br />Caractères acceptés : Lettre de A à Z et chiffre de 0 à 9</div>"; 
    }	
    if(!preg_match($verif_cp, $_POST['cp']) || (strlen($_POST['cp']) < 1 || strlen($_POST['cp']) > 5) ){
        $contenu .= "<div class='erreur'>Saisir un code postal valide à 5 chiffres</div>"; 
    }	
    if(!preg_match($verif_adresse, $_POST['adresse']) || (strlen($_POST['adresse']) < 1 || strlen($_POST['adresse']) > 30) ){
        $contenu .= "<div class='erreur'>L'adresse doit contenir entre 1 et 20 caractères. <br />Caractères acceptés : Lettre de A à Z et chiffre de 0 à 9</div>"; 
    }	
    if(empty($contenu))
    {
        $membre = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");

        if($membre->num_rows > 0)
        {
            $contenu .= "<div class='erreur'>Pseudo indisponible. Veuillez en choisir un autre SVP.</div>";
        }
        else
        {
            foreach($_POST as $indice => $valeur)
            {
                $_POST[$indice] = htmlentities(addSlashes($valeur));
            }
            executeRequete("INSERT INTO membre(pseudo, mdp, nom, prenom, email, sexe, ville, cp, adresse) VALUES('$_POST[pseudo]', '$hash_mdp' , '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[sexe]', '$_POST[ville]', '$_POST[cp]', '$_POST[adresse]')");
            $contenu .= "<div class='validation'>Vous êtes inscrit à notre site web. <a href=\"connexion.php\">Cliquez ici pour vous connecter</a></div>";
        }
    }
}

//********* Affichage HTML *********//

require_once("inc/haut.inc.php");
require_once("inc/menu.inc.php");
echo $contenu;
echo'
<form method="post" action="">

    <label for="pseudo">Pseudo* :</label><br />
    <input type="text" name="pseudo" id="pseudo" /><br /><br />

    <label for="mdp">Mot de passe* :</label><br />
    <input type="password" name="mdp" id="mdp" /><br /><br />

    <label for="nom">Nom* :</label><br />
    <input type="text" name="nom" id="nom" /><br /><br />

    <label for="prenom">Prénom* :</label><br />
    <input type="text" name="prenom" id="prenom" /><br /><br />

    <label for="email">Email* :</label><br />
    <input type="email" name="email" id="email" /><br /><br />

    <label for="sexe">Sexe* :</label><br />
    <input type="radio" name="sexe" value="m" checked />Homme<br />
    <input type="radio" name="sexe" value="f" />Femme<br /><br />

    <label for="ville">Ville* :</label><br />
    <input type="text" name="ville" id="ville" /><br /><br />

    <label for="cp">Code postal* :</label><br />
    <input type="text" name="cp" id="cp" /><br /><br />

    <label for="adresse">Adresse* :</label><br />
    <textarea name="adresse" id="adresse" ></textarea><br /><br />

    <input type="submit" id="valider" name="valider" value="valider"/>
</form>';

require_once("inc/bas.inc.php"); 
?>
