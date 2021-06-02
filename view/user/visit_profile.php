<h2>Profil de <?=$visit_user->getHis('login');?></h2>
<h3 id="div_followers"><a href="followers&user=<?=$visit_user->getHis('login');?>">Followers : <?=$visit_user->getHis('followers');?></a></h3>
<h3 id="div_following"><a href="followings&user=<?=$visit_user->getHis('login');?>">Following : <?=$visit_user->getHis('followings');?></a></h3>
<?php
    if(isset($user) && $visit_user->isFollowing($user->getHis('id'))){ ?>
        <p><?=$visit_user->getHis('login');?> vous suit.</p>
    <?php }
    if(isset($user) && $user->isFollowing($visit_user->getHis('id')) ){ ?>
        <div id="un-fo_button">
            <p>Vous suivez <?=$visit_user->getHis('login');?></p>
            <button id="unfollow_button">Se désabonner</button>
        </div>
    <?php }
    else { ?>
        <div id="un-fo_button">
            <button id="follow_button">S'abonner</button>
        </div>
    <?php } ?>
<section>
    <h4>Galerie</h4>
</section>

<script>
    userid = "<?php echo isset($user) ? $user->getHis('id') : 0 ?>"
    followid = "<?php echo isset($visit_user) ? $visit_user->getHis('id') : 0 ?>"
</script>