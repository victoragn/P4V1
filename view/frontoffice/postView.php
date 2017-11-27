<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>
<h1>Mon super blog !</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        <?= htmlspecialchars($post->title()) ?>
        <em>le <?= $post->creationDate() ?></em>
    </h3>
            
    <p>
        <?= nl2br(htmlspecialchars($post->content())) /*nl2br met les retours à la ligne*/ ?>
    </p>
</div>

<h2>Commentaires</h2>
<form action="index.php?action=addComment&amp;id=<?= $post->id() ?>" method="post">
    <div>
        <label for="comment">Ajoutez votre commentaire</label><br />
        <textarea id="comment" name="comment"></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>

<?php
foreach ($comments as &$comment){
?>
<p><strong><?= htmlspecialchars($comment->authorId()) ?></strong> le <?= $comment->commentDate() ?></p>
    <p><?= nl2br(htmlspecialchars($comment->comment())) ?></p>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('/view/template.php'); ?>



