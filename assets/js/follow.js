$(function(){
    $(document).on('click', "#unfollow_button", function(){
        if(userid>0 && followid>0){
            $.post('model/social/Unfollow.php', {
                unfollow : 1,
                user1 : userid, 
                user2 : followid
            }, function(data){
                if(data==0){
                    $('#un-fo_button').html('<button id="follow_button">S\'abonner</button> <i class="fas fa-check"></i> Désabonné')
                    $("#div_followers").load(window.location.href + " #div_followers")
                }
            })
        }
    })
    $(document).on('click', "#follow_button", function(){
        if(userid>0 && followid>0){
            $.post('model/social/Follow.php', {
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