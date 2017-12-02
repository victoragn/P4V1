<?php
global $currentUser;
?>

<div id="userHeader">
    <span id="pseudoHeader"><?= $currentUser->pseudo(); ?></span>
    <a href="index.php?action=disconnect">Se déconnecter</a>
</div>
