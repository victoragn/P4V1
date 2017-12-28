<?php
    $title = 'Modifier le profil';
    $pageTitle = 'Modifier le profil';
    $description='Page pour modifier son profil - Blog de Jean Forteroche'
?>

<?php ob_start(); ?>
<p><a href="index.php">Retour à l'accueil</a></p>

<div id="messagesInfos">
    <?php
        if (isset($checkEmail) && $checkEmail==1){echo "Cet email est déjà utilisé par quelqun d'autre !";}
        if (isset($champPassVide) && $champPassVide==1){echo "Si vous souhaitez modifier le mot de passe, les 3 champs doivent être remplis !";}
        if (isset($champPassDiff) && $champPassDiff==1){echo "Les deux champs du nouveau mot de passe sont différents !";}
        if (isset($checkOldPass) && $checkOldPass==false){echo "L'ancien mot de passe est faux !";}
        if (isset($modifPassword) && $modifPassword==1){echo "Le mot de passe a bien été modifié";}
        if (isset($modifEmail) && $modifEmail==1){echo "L\'email a bien été modifié";}
    ?>
</div>

<div class="profilForm">
   <form action="index.php?action=profil" method="post">
        <div class="cadreModifProfil"><span class="titreModifProfil">Modifier le mot de passe :</span><br />
            <label class="profilLabel" for="oldPass">Ancien mot de passe</label>
            <input id="oldPasswordInput" type="password" name="oldPass" />
            <br />

            <label class="profilLabel" for="changePass1">Mot de passe</label>
            <input id="changePassInput1" type="password" name="changePass1"/>
            <br />

            <label class="profilLabel" for="changePass2">Retapez le mot de passe</label>
            <input id="changePassInput2" type="password" name="changePass2"/>
            <br />
        </div>
       <div class="cadreModifProfil"><span class="titreModifProfil">Changer votre email :</span><br />
            <label class="profilLabel" for="changeEmail">Email</label>
            <input id="email_input" type="email" name="changeEmail" value="<?php
                if(isset($_SESSION['email'])){echo htmlspecialchars($_SESSION['email']);?>" />
        </div>
        <div>
            <input class="frontBtn cadreModifProfil" type="submit" />
        </div>
    </form>
</div>

<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('templateIndex.php'); ?>
