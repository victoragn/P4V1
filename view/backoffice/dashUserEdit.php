<?php $title = 'Modifier un membre'; ?>

<?php ob_start(); ?>
<h1>Modifier un membre</h1>
<a href="index.php?action=dashboard&page=users">Gerer les membres</a>
<a href="index.php">Retour à l'acceuil</a>

<div id="messagesInfos">
    <?php
        if (isset($checkEmail) && $checkEmail==1){echo "Cet email est déjà utilisé par quelqun d'autre !";}
        if (isset($champPassVide) && $champPassVide==1){echo "Si vous souhaitez modifier le mot de passe, les 3 champs doivent être remplis !";}
        if (isset($champPassDiff) && $champPassDiff==1){echo "Les deux champs du nouveau mot de passe sont différents !";}
        if (isset($modifPassword) && $modifPassword==1){echo "Le mot de passe a bien été modifié";}
        if (isset($modifEmail) && $modifEmail==1){echo "L\'email a bien été modifié";}
    ?>
</div>
<h2>Infos de <?= $user->getPseudo(); ?></h2>
<div class="profilForm">
   <form action="index.php?action=profil" method="post">
       <div>Changer le pseudo : <br />
            <label for="changePseudo">Pseudo</label>
            <input id="pseudo_input" type="text" name="changePseudo" value="<?= $user->getPseudo(); ?>" />
        </div>

       <div>Modifier le mot de passe : <br />
            <label for="changePass1">Mot de passe</label>
            <input id="changePassInput1" type="password" name="changePass1"/>
            <br />

            <label for="changePass2">Retapez le mot de passe</label>
            <input id="changePassInput2" type="password" name="changePass2"/>
            <br />
        </div>
        <div>Changer l'email : <br />
            <label for="changeEmail">Email</label>
            <input id="email_input" type="email" name="changeEmail" value="<?= $user->getEmail(); ?>" />
        </div>
        <div>
            <input type="submit" />
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateDashboard.php'); ?>
