<section>
    <?php echo isset($settings_return) && $settings_return ? '<p id="settings_return">' . $settings_return . '</p>' : null;?>

    <!-- Profile picture -->
    <?php if($user->getHis('picture')==0){ ?>
        <p>Vous n'avez pas encore de photo de profil.</p>
    <?php } 
    else{ ?>
        <img src ="<?= 'http://localhost/social-network/' . $user->getHis('picture');?>" style="width:250px;" alt="profile_picture">
        <h3>Modifier mon image</h3>
        <form method="post" action="settings">
            <input type="hidden" name="delete_picture" value="1">
            <button id="delete_picture_button">Supprimer l'image</button>
        </form> 
    <?php }?>
        <form method="post" action="settings" enctype="multipart/form-data">  
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
            <button type="submit" name="submit_profile_picture">Envoyer</button>
        </form>

    <!-- Background picture -->
    <?php if($user->getHis('background')==0){ ?>
        <p>Vous n'avez pas encore choisi d'arrière plan</p>
    <?php } 
    else{ ?>
        <img src ="<?= 'http://localhost/social-network/' . $user->getHis('background');?>" style="width:250px;" alt="profile_background">
        <h3>Modifier mon arrière plan</h3>
        <form method="post" action="settings">
            <input type="hidden" name="delete_background" value="1">
            <button id="delete_background_button">Supprimer l'image</button>
        </form>
    <?php } ?>
    <form method="post" action="settings" enctype="multipart/form-data">
        <input type="file" name="profile_background" id="profile_background" accept="image/*">
        <button type="submit" name="submit_profile_background">Envoyer</button>
    </form>

    <!-- Password / Mail -->
    <form method="post" action="settings">
        <input type="password" name="modify_password" minlength="8" placeholder="********" required>
        <button type="submit" name="submit_modify_password">Modifier mon mot de passe</button>
    </form>
    <form method="post" action="settings">
        <input type="email" name="modify_mail" minlength="5" maxlength="40" value="<?=$user->getHis('mail');?>" required>
        <button type="submit" name="submit_modify_mail">Modifier mon adresse mail</button>
    </form>

    <hr>
    <form method="post" action="delete" id="form_delete_account">
        <input type="hidden" name="delete_account" value="1">
        <button id="submit_delete_account">Supprimer mon compte</button>
    </form>
    <p><a href="profil">Retour</a></p>
</section>
