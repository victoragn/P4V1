<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>
<h1>Mon super blog !</h1>
<p>Derniers billets du blog :</p>


<?php
foreach ($posts as &$post){
?>
    <div class="news">
        <h3>
            <?= $post->getTitle(); ?>
            <em>le <?= $post->getCreationDate(); ?></em>
        </h3>
        
        <p>
            <?= $post->getContent(); ?>
            <br />
            <em><a href="index.php?action=post&id=<?= $post->getId(); ?>">Commentaires</a></em>
        </p>
    </div>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('/view/template.php'); ?>
