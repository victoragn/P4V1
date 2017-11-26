<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>
<h1>Mon super blog !</h1>
<p>Derniers billets du blog :</p>


<?php
foreach ($posts as &$post){
?>
    <div class="news">
        <h3>
            <?= htmlspecialchars($post->title()) ?>
            <em>le <?= $post->creationDate() ?></em>
        </h3>
        
        <p>
            <?= nl2br(htmlspecialchars($post->content())) /*nl2br permet le retour à la ligne avec htmlspecialchars*/ ?>
            <br />
            <em><a href="index.php?action=post&id=<?= $post->id() ?>">Commentaires</a></em>
        </p>
    </div>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('/view/template.php'); ?>
