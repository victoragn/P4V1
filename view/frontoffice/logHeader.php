<div id="logHeader">
    <form method="post" action="#">
        <div>
            <label for="pseudo">Pseudo</label>
            <input id="pseudo_input" type="text" name="pseudo" value="<?php if(isset($_POST['pseudo'])){echo htmlspecialchars($_POST['pseudo']);}?>" />
            <br />
            
            <label for="password">Mot de passe</label>
            <input id="password_input1" type="password" name="password"/>
            <br />
            
        </div>
        <div>
            <input type="submit" value="Connexion"/>
        </div>
        <div>
            <a href="register.php">S'inscrire</a>
        </div>
    </form>


</div>
