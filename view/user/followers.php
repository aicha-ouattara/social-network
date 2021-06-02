<section>
    <?php foreach($followers as $key => $value){?>
        <a href="profil&user=<?=$value;?>"><?=$value;?></a>
    <?php } 
    if(empty($followers)){
        if($_GET['user'] == $user->getHis('login')){ ?>
            <p>Vous n'avez pas encore de follower.</p>
        <?php }
        else{ ?>
            <p><?=$_GET['user'];?> n'a pas encore de follower.</p>
        <?php }
    } ?>
</section>