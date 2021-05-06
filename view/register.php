<?php require 'elements/head.php';?>

<form method="post" action="model/register.php">
    <label for="login">Pseudo :</label>
    <input type="text" name="login" minlength="4" maxlength="24" required>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" minlength="8" required>
    <label for="cpassword">Confirmez le mot de passe :</label>
    <input type="password" name="cpassword" minlength="8" required>
    <label for="mail">Adresse mail :</label>
    <input type="email" name="mail" minlength="5" maxlength="40" required>
</form>

<?php require 'elements/footer.php';?>