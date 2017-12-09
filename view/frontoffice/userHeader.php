<div id="userHeader">
    <span id="pseudoHeader"><?= $_SESSION['pseudo']; ?></span>
    <?php if($_SESSION['role']==1){ ?>
    <a href="index.php?action=dashboard">Gérer le site</a>
    <?php
    }
    ?>
    <a href="index.php?action=disconnect">Se déconnecter</a>
</div>
