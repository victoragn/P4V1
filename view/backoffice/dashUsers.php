<?php $title = 'Gestion des membres'; ?>

<?php ob_start(); ?>
<h1>Gestion des membres</h1>
<a href="index.php?action=dashboard">Gerer les articles</a>
<a href="index.php">Retour à l'acceuil</a>

<div>
    <table>
        <thead>
            <th>Numéro d'id</th>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Modifier</th>
        </thead>
        <tbody>
        <?php
        foreach ($users as &$user){
        ?>
            <tr id= "User<?= $user->getId(); ?>">
                <td> <?= $user->getId(); ?></td>
                <td> <?= $user->getPseudo(); ?></td>
                <td> <?= $user->getEmail(); ?></td>
                <td><a href="index.php?action=dashboard&page=users&userId=<?= $user->getId(); ?>"><button class="btnModifUser">Modifier</button></a></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateDashboard.php'); ?>
