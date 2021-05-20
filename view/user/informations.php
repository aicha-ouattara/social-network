<section>
    <h2>Informations personnelles</h2>

    <form method="post" action="informations" style="display:flex;flex-flow:column;">
        <label for="bio">Bio :</label>
        <textarea name="bio" rows="5" cols="40" placeholder="Je m'appelle John, j'ai 28 ans et j'habite à Bordeaux...">
            <?php echo !in_array($user->getHis('bio'), [0, null, '']) ? $user->getHis('bio') : null ?>
        </textarea>
        <label for="country">Pays :</label>
        <select name="country">
            <option value=""></option>
            <option value="France">France</option>
            <option value="Belgique">Belgique</option>
            <option value="Suisse">Suisse</option>
            <option value="Royaume-Uni">Royaume-Uni</option>
            <option value="Irlande">Irlande</option>
            <option value="Allemagne">Allemagne</option>
            <option value="Espagne">Espagne</option>
            <option value="Italie">Italie</option>
            <option value="Pologne">Pologne</option>
            <option value="Danemark">Danemark</option>
            <option value="Finlande">Finlande</option>
            <option value="Suède">Suède</option>
            <option value="Norvège">Norvège</option>
        </select>
        <label for="city">Ville :</label>
        <input type="text" name="city" min="2" max="40" value="<?=null !== $user->getHis('city') ? $user->getHis('city') : null;?>">
        <label for="lastname">Nom :</label>
        <input type="text" name="lastname" value="<?=$user->getHis('lastname');?>" min="1" max="40">
        <label for="firstname">Prénom :</label>
        <input type="text" name="firstname" value="<?=$user->getHis('firstname');?>" min="1" max="40">
        <label for="birthdate">Date de naissance :</label>
        <input type="date" name="birthdate" value="<?=$user->getHis('birthdate');?>" min="1921-01-01" max="<?=date('Y-m-d');?>">
        <label for="phone">Téléphone :</label>
        <input type="tel" name="phone" pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}" placeholder="01-23-45-67-89" value="<?=$user->getHis('phone');?>">
        <button name="submit">Mettre à jour</button>
    </form>

    <a href="profil">Retour</a>
</section>

<script>
    $(function(){
        const country = "<?= $user->getHis('country');?>"
        $("option[value=" + country +"]").attr('selected', 'selected')
    })
</script>