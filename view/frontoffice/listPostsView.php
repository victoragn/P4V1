<?php
    $title = 'Jean Forteroche';
    $title2= 'Le Blog';
    $pageTitle='Jean Forteroche - Le blog';
    $description='Retrouvez toutes les semaines un nouveau chapitre de notre aventure !';
?>

<?php ob_start(); ?>
<div id="pPresentation">
    <h2>Bienvenue sur le blog de Jean Forteroche</h2>
    <p>Vous retrouverez ici chaque vendredi le nouveau chapitre de mon nouveau roman. Cela, je l'espere, vous fera bien commencer le week-end. Vous pouvez bien sur laisser des commentaires à la fin de chaque chapitre pour me donner vos impressions.</p>
</div>


<?php
foreach ($posts as &$post){
?>
    <div class="news">
        <a href="index.php?action=post&id=<?= $post->getId(); ?>">
            <h3>
                <?= $post->getTitle(); ?>
                <em>le <?= $post->getCreationDate(); ?></em>
            </h3>

            <p><?= $post->getExcerpt2(); ?>...</p>
            <p class="ligneVoirPlus"><button class="frontBtn">Lire le chapitre</button> Il y a <?= $post->getNbComment(); ?> commentaire(s).</p>
        </a>
    </div>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('templateIndex.php'); ?>
