<?php
    $title = 'Modifier un article';
?>

<?php ob_start(); ?>
<a href="index.php?action=dashboard">Retour à la gestion des articles</a>
<a href="index.php">Retour à l'acceuil</a>

<form method="post" action="index.php?action=dashboard&editPost=<?= $post->getId(); ?>">
    <label>Titre de l'article<input type="text" name="titlePost" value="<?= $post->getTitle(); ?>"></label>
    <textarea id="mytextarea" name="editedPost"><?= $post->getContent(); ?></textarea>
    <input type="submit" value="Publier">
</form>

<?php $content = ob_get_clean(); ?>

<?php require('templateDashboard.php');
