<section>
    <?php foreach($followings as $key=>$value){?>
        <a href="profil&user=<?=$value;?>"><?=$value;?></a>
    <?php } 
    if(empty($followings)){
        if($_GET['user'] == $user->getHis('login')){ ?>
            <p>Vous ne suivez pas encore d'utilisateur.</p>
        <?php } 
        else{ ?>
            <p><?=$_GET['user'];?> ne suit pas encore d'utilisateur.</p>
        <?php }
    } ?>
</section>