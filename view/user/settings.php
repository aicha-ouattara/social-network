<section>
    <?php if($user->getHis('picture')==0){ ?>
        <form method="post" action="settings" enctype="multipart/form-data">
            <p>Vous n'avez pas encore de photo de profil.</p>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
            <button type="submit" name="submit_profile_picture">Envoyer</button>
        </form>
    <?php } 
    else{ ?>
        <img src ="<?= ROOT . $user->getHis('picture');?>" style="width:250px;" alt="profile_picture">
        <form method="post" action="settings" enctype="multipart/form-data">
            <h3>Modifier mon image</h3>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
            <button type="submit" name="submit_profile_picture">Envoyer</button>
        </form>
    <?php }?>
    <?php if($user->getHis('background')==0){ ?>
        <form method="post" action="settings" enctype="multipart/form-data">
            <p>Vous n'avez pas encore choisi d'arrière plan'</p>
            <input type="file" name="profile_background" id="profile_background" accept="image/*">
            <button type="submit" name="submit_profile_background">Envoyer</button>
        </form>
    <?php } 
    else{ ?>
        <img src ="<?= ROOT . $user->getHis('background');?>" style="width:250px;" alt="profile_background">
        <form method="post" action="settings" enctype="multipart/form-data">
            <h3>Modifier mon arrière plan</h3>
            <input type="file" name="profile_background" id="profile_background" accept="image/*">
            <button type="submit" name="submit_profile_background">Envoyer</button>
        </form>
    <?php } ?>
    <form method="post" action="settings">
        <input type="password" name="modify_password" minlength="8" placeholder="********" required>
        <button type="submit" name="submit_modify_password">Modifier mon mot de passe</button>
    </form>
    <form method="post" action="settings">
        <input type="email" name="modify_mail" minlength="5" maxlength="40" value="<?=$user->getHis('mail');?>" required>
        <button type="submit" name="submit_modify_mail">Modifier mon adresse mail</button>
    </form>
</section>
