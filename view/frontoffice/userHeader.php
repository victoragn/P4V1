<?php
if(isset($_SESSION['author_id'])){//si la session est lancée est que l'id est définie
        $currentUser=getUserById($_SESSION['author_id']);
    }
?>

<div id="userHeader">
    <span id="pseudoHeader"><?= $currentUser->pseudo(); ?></span>
    <a href="index.php?action=disconnect">Se déconnecter</a>
</div>
