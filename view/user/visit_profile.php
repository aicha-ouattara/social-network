<h2>Profil de <?=$visit_user->getHis('login');?></h2>
<h3 id="div_followers">Followers : <?=$visit_user->getHis('followers');?></h3>
<h3 id="div_following">Following : <?=$visit_user->getHis('followings');?></h3>
<?php
    if(isset($user) && $visit_user->isFollowing($user->getHis('id'))){ ?>
        <p><?=$visit_user->getHis('login');?> est abonné à vous.</p>
    <?php }
    if(isset($user) && $user->isFollowing($visit_user->getHis('id')) ){ ?>
        <div id="un-fo_button">
            <p>Vous êtes abonné à <?=$visit_user->getHis('login');?></p>
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
    $(function(){
        userid = "<?php echo isset($user) ? $user->getHis('id') : 0 ?>"
        followid = "<?php echo isset($visit_user) ? $visit_user->getHis('id') : 0 ?>"
        $(document).on('click', "#unfollow_button", function(){
            if(userid>0 && followid>0){
                $.post('model/Social/Unfollow.php', {
                    unfollow : 1,
                    user1 : userid, 
                    user2 : followid
                }, function(data){
                    if(data==0){
                        $('#un-fo_button').html('<button id="follow_button">S\'abonner</button> <i class="fas fa-check"></i> Désabonné')
                        // $('#div_followers').html("Followers : " + followers)
                        $("#div_followers").load(window.location.href + " #div_followers")
                    }
                })
            }
        })
        $(document).on('click', "#follow_button", function(){
            if(userid>0 && followid>0){
                $.post('model/Social/Follow.php', {
                    follow : 1,
                    user1 : userid, 
                    user2 : followid
                }, function(data){
                    if(data==1){
                        $('#un-fo_button').html('<button id="unfollow_button">Se désabonner</button> <i class="fas fa-check"></i> Abonné')
                        $('#div_followers').load(document.URL + " #div_followers")
                    }
                })
            }
            else $('#un-fo_button').append('Vous devez être connecté.')
        })
    })
</script>