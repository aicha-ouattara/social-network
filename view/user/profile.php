<main>
    <h2><?=$user->getHis('login');?></h2>
    <h3><?=$user->getHis('mail');?></h3>
    <h4><?=$user->getHis('tokens');?> KOins</h4>
    <p>Followers : <?=$user->getHis('followers');?></p>
    <p>Following : <?=$user->getHis('followings');?></p>
    <div id="settings">
        <button id="upload_picture">Changer ma photo de profil</button>
        <button id="modify_informations">Mettre à jours mes informations personnelles</button>
        <button id="modify_mail">Modifier mon adresse mail</button>
        <button id="modify_password">Modifier mon mot de passe</button>
    </div>
</main>