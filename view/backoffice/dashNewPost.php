<?php $title = 'Créer un nouvel article'; ?>

<?php ob_start(); ?>
<h1>Créer un nouvel article</h1>
<a href="index.php?action=dashboard">Retour à la gestion des articles</a>
<a href="index.php">Retour à l'acceuil</a>

<form method="post" action="index.php?action=dashboard">
    <label>Titre de l'article<input type="text" name="titlePost"></label>
    <textarea id="mytextarea" name="newPost"></textarea>
    <input type="submit" value="Publier">
</form>

<?php $content = ob_get_clean(); ?>

<?php require('templateDashboard.php');
