<?php $title = 'Gestion des Articles'; ?>

<?php ob_start(); ?>
<h1>Gestion des articles</h1>
<a href="index.php?action=dashboard&page=users"><button class="backBtn">Gerer les membres</button></a>
<a href="index.php"><button class="backBtn">Retour à l'acceuil</button></a>

<div>
    <a href="index.php?action=dashboard&page=newPost"><button>Créer un nouvel article</button></a>
    <table>
        <thead>
            <th>Titre de l'article</th>
            <th>Début de l'article</th>
            <th>Nombre de commentaires</th>
            <th>Date de création</th>
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
                <td> <?= $post->getNbComment(); ?></td>
                <td> <?= $post->getCreationDate(); ?></td>
                <td><button class="btnModifPost">Modifier</button></td>
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
