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
    <?php }?>
    <?php if($user->getHis('background')==0){
        echo "no background";
    }
    else echo "background";?>
</section>
