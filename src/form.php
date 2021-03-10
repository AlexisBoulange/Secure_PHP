
    <form action="login.php" method="post">
    
        <p><input type="text" placeholder="Votre login" name="username" required></p>

        <p><input type="password" placeholder="Votre mot de passe" name="password" required></p>

        <p><input type="hidden"   value="<?= $_SESSION["token"]?>" name="token" ></p>

        <p><input type="submit" value="Connexion" class="button" ></p>
    </form>
