<?php if(isset($delete_return)) echo '<p>' . $delete_return . '</p>';
else{?>
<section>
    <form method="post" action="delete">
        <p>Êtes-vous sûr de vouloir supprimer votre compte ?</p>
        <button type="submit" name="confirm_delete" value="1">Oui</button>
        <a href="profil">Non</a>
    </form>
</section>
<?php } ?>