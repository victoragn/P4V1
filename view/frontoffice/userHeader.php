<div id="userHeader">
    <span id="pseudoHeader"><?= ucfirst($_SESSION['pseudo']); ?></span>
    <br/>
    <?php if($_SESSION['role']==1){ ?>
    <a href="index.php?action=dashboard"><button class="frontBtn">Gérer le site</button></a><br/>
    <?php
    }
    ?>
    <a href="index.php?action=profil"><button class="frontBtn">Gérer le profil</button></a><br/>
    <a href="index.php?action=disconnect"><button class="frontBtn">Se déconnecter</button></a>
</div>
