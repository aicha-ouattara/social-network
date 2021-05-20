<?php if(isset($register_return) && $register_return){?>
    <p><?=$register_return;?></p>
<?php } else { ?>
<form id="register_form" method="post" action="register">
    <label for="login">Pseudo :</label>
    <input type="text" name="login" minlength="4" maxlength="30" required>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" minlength="8" required>
    <label for="cpassword">Confirmez le mot de passe :</label>
    <input type="password" name="cpassword" minlength="8" required>
    <label for="mail">Adresse mail :</label>
    <input type="email" name="mail" minlength="5" maxlength="40" required>
    <input type="submit" name="submit" value="Valider">
</form>
<?php } ?>