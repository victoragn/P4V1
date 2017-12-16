<?php $title = 'Gestion des membres'; ?>

<?php ob_start(); ?>
<h1>Gestion des membres</h1>
<a href="index.php?action=dashboard">Gerer les membres</a>
<a href="index.php">Retour à l'acceuil</a>

<div>
    <table>
        <thead>
            <th>Numéro d'id</th>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Modifier Mot de passe</th>
            <th>Supprimer</th>
        </thead>
        <tbody>
        <?php
        foreach ($users as &$user){
        ?>
            <tr id= "User<?= $user->getId(); ?>">
                <td> <?= $user->getId(); ?></td>
                <td> <?= $user->getPseudo(); ?></td>
                <td> <?= $user->getEmail(); ?></td>
                <td><button class="btnModifPassUser">Modifier MDP</button></td>
                <td><button class="btnDeleteUser">Supprimer</button></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateDashboard.php'); ?>
