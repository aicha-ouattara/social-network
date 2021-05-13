<main>
    <?php if(!in_array($user->getHis('picture'), [0, null])){ ?> 
        <img src ="<?= ROOT . $user->getHis('picture');?>" style="width:250px;" alt="profile_picture"> <?php } ?>
    <h2><?=$user->getHis('login');?></h2>
    <h3><?=$user->getHis('mail');?></h3>
    <h4><?=$user->getHis('tokens');?> KOins</h4>
    <p>Followers : <?=$user->getHis('followers');?></p>
    <p>Following : <?=$user->getHis('followings');?></p>
    <a href="settings">Paramètres</a>
    <a href="informations">Informations personnelles</a>
</main>