<?php $title = 'Jean Forteroche'; ?>
<?php $title2= 'Le Blog'; ?>

<?php ob_start(); ?>
<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="post">
    <h2><?= $post->getTitle(); ?></h2>
    <em>le <?= $post->getCreationDate(); ?></em>
            
    <p><?= $post->getContent(); ?></p>
</div>

<h2 id="titreComm">Commentaires</h2>
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
    <p><strong><?= ucfirst($comment->getUser()->getPseudo()); ?></strong> le <?= $comment->getCommentDate();
        if(isset($_SESSION['author_id'])){
            if($_SESSION['author_id']!=$comment->getAuthorId()){
                if ( $comment->checkSignalByUserId($_SESSION['author_id'])==1 ){?>
                    <a href="index.php?action=post&id=<?= $post->getId(); ?>&signal=off&commentId=<?= $comment->getId(); ?>">
                        <button class="btnSignalOn">Dé-signaler</button>
                    </a>
                <?php }else{?>
                    <a href="index.php?action=post&id=<?= $post->getId(); ?>&signal=on&commentId=<?= $comment->getId(); ?>">
                        <button class="btnSignalOff">Signaler</button>
                    </a>
                <?php }
            }

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



