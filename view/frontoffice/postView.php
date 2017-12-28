<?php
    $title = 'Jean Forteroche';
    $title2= 'Le Blog';
    $pageTitle=$post->getTitle();
    $description=$post->getExcerpt();
?>

<?php ob_start(); ?>
<p><a href="index.php"><button class="frontBtn">Retour à la liste des billets</button></a></p>

<div class="post">
    <h2><?= $post->getTitle(); ?></h2>
    <em class="datePost">le <?= $post->getCreationDate(); ?></em>
            
    <p><?= $post->getContent(); ?></p>
</div>
<div id="comments">
    <h2 id="titreComm">Commentaires</h2>
<?php
if(isset($_SESSION['author_id'])){//si la session est lancée est que l'id est définie?>

<form id="commentForm" action="index.php?action=addComment&amp;id=<?= $post->getId(); ?>" method="post">
    <div>
        <label for="comment">Ajoutez votre commentaire</label><br />
        <textarea id="commentInput" name="comment"></textarea>
    </div>
    <div>
        <input class="frontBtn" type="submit" />
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
                    <a class="aBtn" href="index.php?action=post&id=<?= $post->getId(); ?>&signal=off&commentId=<?= $comment->getId(); ?>">
                        <button class="btnSignalOn frontBtn">Dé-signaler</button>
                    </a>
                <?php }else{?>
                    <a class="aBtn" href="index.php?action=post&id=<?= $post->getId(); ?>&signal=on&commentId=<?= $comment->getId(); ?>">
                        <button class="btnSignalOff frontBtn">Signaler</button>
                    </a>
                <?php }
            }

            if($comment->getAuthorId()==$_SESSION['author_id']||$_SESSION['role']==1){
                ?><button class="btnModifComment frontBtn" >Modifier</button><button class="btnDeleteComment frontBtn" >Supprimer</button> <?php
            }
        }
        ?>
    </p>
    <p class='contentComment'><?= $comment->getComment(); ?></p>
</div>

<?php
}
?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('templateIndex.php'); ?>



