<?php if(isset($connect_return) && $connect_return){ ?>
    <p><?=$connect_return;?></p>
<?php } else{ ?>
<form id="connection_form" method="post" action="connection">
    <label for="login">Pseudo ou adresse mail :</label>
    <input type="text" name="login" minlength="4" maxlength="30" required>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" minlength="8" required>
    <input type="submit" name="submit" value="Valider">
</form>
<?php } ?>