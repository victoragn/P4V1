<?php $title = 'Créer un nouvel article'; ?>

<?php ob_start(); ?>
<h1>Créer un nouvel article</h1>
<a href="index.php?action=dashboard">Retour à la gestion des articles</a>
<a href="index.php">Retour à l'acceuil</a>
<?php if(isset($champVide)&& $champVide==true){
?>
<div id="messChampVide">Le titre et le contenu ne doivent ni l'un ni l'autre etre vide.</div>
<?php
}
?>


<form method="post" action="index.php?action=dashboard">
    <label>Titre de l'article<input type="text" name="titlePost" value="<?php if(isset($postTitle)){echo $postTitle;} ?>"></label>
    <textarea id="mytextarea" name="newPost"><?php if(isset($postContent)){echo $postContent;} ?></textarea>
    <input type="submit" value="Publier">
</form>

<?php $content = ob_get_clean(); ?>

<?php require('templateDashboard.php');
