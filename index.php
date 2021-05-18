<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" media="screen and (min-width: 1050px)" href="css/script.css">
    <link rel="stylesheet" media="screen and (max-width: 1050px)" href="css/phone.css">


    <title>Document</title>
</head>

<body>

<main id="main">

<!--    LOGO PLATEFORME-->
<div class="container_top">
    <div class="logo"><img src="img/logoplateforme.png"> </div>
</div>

<div class="container_bottom">
    <!--    BOUTON LOGIN -->
    <div  class="container">
        <img src="img/logo1.png"  class="image">
        <div class="overlay">
            <div  id="login" class="text">Login </div>
        </div>
    </div>

    <!--    LOGO REGISTER -->

    <div class="container">
        <img src="img/logo2.png"  class="image">
        <div class="overlay">
            <div id="register" class="text">Sign Up </div>
        </div>
    </div>

</div>




</main>

<!--///////////////////FORMULAIRE CONNEXION///////-->
<div id="popup_login">
    <form class="login-form" >
        <h1>Login</h1>
        <input type="text" name="username" id="username" placeholder="EMAIL" required /><br>
        <input type="password" name="password" id="password" placeholder="PASSWORD" required /><br>
        <button type="submit" class="btn" >{ OK }</button>
    </form>
</div>

<!--///////////////////FORMULAIRE INSCRIPTION///////-->
<div id="popup_register">

    <header>

    </header>

    <form class="login-form" >

        <div class="page" id="page1">
        <h1>Inscription</h1>
            <small id="output_nom"></small>
            <input type="text" name="nom" id="nom" placeholder="NOM" required /><br>

            <small id="output_prenom"></small>
            <input type="text" name="prenom" id="prenom" placeholder="PRENOM" required /><br>


            <input type="email" name="email" id="email" placeholder="EMAIL" required /><br>
            <button class="next" type="button">Suivant</button>
        </div>
        <div class="page" id="page2">
            <h1>Inscription</h1>
            <label for="photo">Photo de profil : </label>
            <input type="file"  id="photo" name="photo" accept="image/png, image/jpeg"><br>
            <label for="birth">Date de naissance</label>

            <input type="date" id="birth" name="birth"
                   value="1996-07-22"><br>

            <small id="output_phone"></small>
            <input type="tel" placeholder="NUMERO DE TELEPHONE" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
            <small>Format: 0618181818</small><br>

            <button class="prev" type="button">Précédent</button>
            <button class="next" type="button">Suivant</button>
        </div>
        <div class="page" id="page3">
            <h1>Inscription</h1>

            <small id="output_username"></small>
            <input type="text" name="username" id="username" placeholder="PSEUDO" required /><br>

            <small id="output_pass1"></small>
            <input type="password" name="pass1" id="pass1" placeholder="PASSWORD" required /><br>

            <small id="output_pass2"></small>
            <input type="password" name="pass2" id="pass2" placeholder="CONFIRMATION PASSWORD" required /><br>

            <button class="prev" type="button">Précédent</button>
            <button class="btn">Terminer</button>

        </div>


    </form>
</div>

<img src="img/friends1.png" class="img_friends">

</body>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="js/home.js"></script>
<script type="text/javascript" src="js/homeForm.js"></script>

</html>