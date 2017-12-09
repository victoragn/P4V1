<?php $title = 'Gestion des Articles'; ?>

<?php ob_start(); ?>
<h1>Gestion des articles</h1>
<a href="index.php?action=dashboard&page=users">Gerer les membres</a>
<a href="index.php">Retour à l'acceuil</a>

<div>
    <button onclick="window.location.href='index.php?action=dashboard&page=newPost'">Créer un nouvel article</button>
    <table>
        <thead>
            <th>Titre de l'article</th>
            <th>Débur de l'article</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </thead>
        <tbody>
        <?php
        foreach ($posts as &$post){
        ?>
            <tr id= "Post<?= $post->getId(); ?>">
                <td> <?= $post->getTitle(); ?></td>
                <td> <?= $post->getExcerpt(); ?></td>
                <td><button class="btnModifPost" onclick="window.location.href='index.php?action=dashboard&page=modifPost&postId=<?=$post->getId()?>'">Modifier</button></td>
                <td><button class="btnDeletePost">Supprimer</button></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateDashboard.php'); ?>
