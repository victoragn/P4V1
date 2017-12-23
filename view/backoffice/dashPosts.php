<?php $title = 'Gestion des Articles'; ?>

<?php ob_start(); ?>
<h1>Gestion des articles</h1>
<a href="index.php?action=dashboard&page=users"><button class="backBtn">Gerer les membres</button></a>
<a href="index.php"><button class="backBtn">Retour à l'acceuil</button></a>

<div>
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
                <td><button class="btnModifPost backBtn">Modifier</button></td>
                <td><button class="btnDeletePost backBtn">Supprimer</button></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <a href="index.php?action=dashboard&page=newPost"><button class="backBtn">Créer un nouvel article</button></a>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateDashboard.php'); ?>
