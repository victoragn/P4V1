<?php
    $title = 'Modifier un article';
?>

<?php ob_start(); ?>
<a href="index.php?action=dashboard"><button class="backBtn">Retour à la gestion des articles</button></a>
<a href="index.php"><button class="backBtn">Retour à l'acceuil</button></a>

<form method="post" action="index.php?action=dashboard&editPost=<?= $post->getId(); ?>">
    <label id="titlePostLabel" for="titlePost">Titre de l'article :<input id="titlePostInput" type="text" name="titlePost" value="<?= $post->getTitle(); ?>"></label>
    <textarea id="mytextarea" name="editedPost"><?= $post->getContent(); ?></textarea>
    <input type="submit" value="Publier">
</form>

<?php $content = ob_get_clean(); ?>

<?php require('templateDashboard.php');
