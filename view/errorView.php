

<?php $title = 'Erreur !'; ?>

<?php ob_start(); ?>
<h1>Une erreur s'est produite !</h1>
<div class="blocErreur">
    <?php 
        echo $errorMessage;
    ?>
</div>

<a href="index.php">Retour à la page d'acceuil</a>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
