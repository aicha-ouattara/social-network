<?php

?>

<section id="new_conversation">
    <h4><?=$partner->getHis('login');?> - <span class="friend_status"><?= $partner->getHis('online') ? 'Connecté' : 'Déconnecté';?></span></h4>
    <form method="post" action="messages">
        <input type="hidden" name="new_conversation" value=1>
        <input type="text" name="message" id="input_m" autocomplete="off">
        <button id="submit_m">Envoyer</button>
    </form>
    <a href="messages">Retour</a>
</section>