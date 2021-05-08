<main>
    <h2><?=$user->getHis('login');?></h2>
    <h3><?=$user->getHis('mail');?></h3>
    <h4><?=$user->getHis('tokens');?> KOins</h4>
    <p>Followers : <?=$user->getHis('followers');?></p>
    <p>Followings : <?=$user->getHis('followings');?></p>
</main>