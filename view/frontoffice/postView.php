<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>
<h1>Mon super blog !</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        <?= $post->getTitle(); ?>
        <em>le <?= $post->getCreationDate(); ?></em>
    </h3>
            
    <p>
        <?= $post->getContent(); /*nl2br met les retours à la ligne*/ ?>
    </p>
</div>

<h2>Commentaires</h2>
<?php
if(isset($_SESSION['author_id'])){//si la session est lancée est que l'id est définie?>

<form action="index.php?action=addComment&amp;id=<?= $post->getId(); ?>" method="post">
    <div>
        <label for="comment">Ajoutez votre commentaire</label><br />
        <textarea id="comment" name="comment"></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>
<?php } ?>

<?php
foreach ($comments as &$comment){
?>
<div id="<?= 'divComment'. $comment->getId(); ?>" class='divComment'>
    <p><strong><?= $userManager->getUserById($comment->getAuthorId())->getPseudo(); ?></strong> le <?= $comment->getCommentDate();
        if(isset($_SESSION['author_id'])){
            if($comment->getAuthorId()==$_SESSION['author_id']||$_SESSION['role']==1){
                ?><button class="btnModifComment" >Modifier</button><button class="btnDeleteComment" >Supprimer</button> <?php
            }
        }
        ?>
    </p>
    <p class='contentComment'><?= $comment->getComment(); ?></p>
</div>

<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('templateIndex.php'); ?>



