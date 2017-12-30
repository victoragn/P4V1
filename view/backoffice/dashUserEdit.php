<?php $title = 'Modifier un membre'; ?>

<?php ob_start(); ?>
<h1>Modifier un membre</h1>
<a href="index.php?action=dashboard&page=users"><button class="backBtn">Gerer les membres</button></a>
<a href="index.php"><button class="backBtn">Retour à l'acceuil</button></a>

<div id="messagesInfos">
    <?php
        if (isset($checkPseudo) && $checkPseudo==1){echo "Ce pseudo est déjà utilisé par quelqun d'autre !";}
        if (isset($checkEmail) && $checkEmail==1){echo "Cet email est déjà utilisé par quelqun d'autre !";}
        if (isset($champPassVide) && $champPassVide==1){echo "Si vous souhaitez modifier le mot de passe, les 3 champs doivent être remplis !";}
        if (isset($champPassDiff) && $champPassDiff==1){echo "Les deux champs du nouveau mot de passe sont différents !";}
        if (isset($modifPassword) && $modifPassword==1){echo "Le mot de passe a bien été modifié";}
        if (isset($modifEmail) && $modifEmail==1){echo "L'email a bien été modifié";}
        if (isset($modifPseudo) && $modifPseudo==1){echo "Le pseudo a bien été modifié";}

    ?>
</div>
<h2>Infos de <?= $userPseudo; ?></h2>
<div class="profilForm">
   <form action="index.php?action=dashboard&page=users&userId=<?= $user->getId(); ?>" method="post">
       <div><span class="titreForm">Changer le pseudo : </span>
            <label for="changePseudo">Pseudo</label>
            <input id="pseudo_input" type="text" name="changePseudo" value="<?= $userPseudo; ?>" />
        </div>

       <div><span class="titreForm">Modifier le mot de passe : </span>
            <label for="changePass1">Mot de passe</label>
            <input id="changePassInput1" type="password" name="changePass1"/>
            <br />

            <label for="changePass2">Retapez le mot de passe</label>
            <input id="changePassInput2" type="password" name="changePass2"/>
            <br />
        </div>
       <div><span class="titreForm">Changer l'email : </span>
            <label for="changeEmail">Email</label>
            <input id="email_input" type="email" name="changeEmail" value="<?= $userEmail; ?>" />
        </div>
        <div>
            <input id="formSubmit" type="submit" />
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateDashboard.php'); ?>
