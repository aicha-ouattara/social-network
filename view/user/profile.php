<main>
    <?php if(!in_array($user->getHis('picture'), [0, null]) && is_file(getcwd() .'/'. $user->getHis('picture'))){ ?> 
        <img src ="<?= 'http://localhost/social-network/' .  $user->getHis('picture');?>" style="width:250px;" alt="profile_picture"> <?php } ?>
    <h2><?=$user->getHis('login');?></h2>
    <form method="post" action="profil">
        <button type="submit" name="disconnect" value="1">Se déconnecter</button>
    </form>
    <h3><?=$user->getHis('mail');?></h3>
    <h4><?=$user->getHis('tokens');?> KOins</h4>
    <p>Followers : <?=$user->getHis('followers');?></p>
    <p>Following : <?=$user->getHis('followings');?></p>
    <a href="messages">Messages</a>
    <a href="settings">Paramètres</a>
    <a href="informations">Informations personnelles</a>
</main>