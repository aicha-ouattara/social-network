$(document).ready(function(){


    /////////////VERIF NOM
    $("#nom").keyup(function(){
        if($(this).val().length < 2){
            $("#output_nom").css("color", "red").html("Veuillez remplir ce champ");
        } else {
            $("#output_nom").html('<img src="img/check.png" class="small_image" alt="" />');
        }
    });

    ///////////////VERIF PRENOM
    $("#prenom").keyup(function(){
        //On vérifie si le mot de passe est ok
        if($(this).val().length < 2){
            $("#output_prenom").css("color", "red").html("Veuillez remplir ce champ");
        } else {
            $("#output_prenom").html('<img src="img/check.png" class="small_image" alt="" />');
        }
    });

    //////////////VERIF EMAIL


    /////////////////VERIF PHOTO?

    //////////////VERIF DATE DE NAISSANCE

    /////////////VERIF NUM

    $("#phone").keyup(function(){
        if($(this).val().length < 10){
            $("#output_phone").css("color", "red").html("Veuillez remplir ce champ selon le format indiqué ci-dessous");
        } else {
            $("#output_phone").html('<img src="img/check.png" class="small_image" alt="" />');
        }
    });

    /////////////VERIF PSEUDO
    $("#username").keyup(function(){
        if($(this).val().length < 5){
            $("#output_username").css("color", "red").html("Le pseudo est trop court");
        } else {
            $("#output_username").html('<img src="img/check.png" class="small_image" alt="" />');
        }
    });


    ///////////////////////VERIF MDP
    $("#pass1").keyup(function(){
        if($(this).val().length < 6){
            $("#output_pass1").css("color", "red").html("<br/>Trop court (6 caractères minimum)");
        } else if($("#pass2").val() != "" && $("#pass2").val() != $("#pass1").val()){
            $("#output_pass1").html("<br/>Les deux mots de passe sont différents");
            $("#output_pass2").html("<br/>Les deux mots de passe sont différents");
        } else {
            $("#output_pass1").html('<img src="img/check.png" class="small_image" alt="" />');
        }
    });

    // $("#pass2").keyup(function(){
    //     //On vérifie si les mots de passe coïncident
    //     check_password();
    // });
    //
    // $("#email").keyup(function(){
    //     //On vérifie si les mots de passe coïncident
    //     check_email();
    // });





});






///////////////////////////////////////////////
//Formulaire multipages
//////////////////////////////////////////////

const pages = document.querySelectorAll(".page")
const header = document.querySelector("header")
const nbPages = pages.length // Nombre de pages du formulaire
let pageActive = 1

// On attend le chargement de la page
window.onload = () => {
    // On affiche la 1ère page du formulaire
    document.querySelector(".page").style.display = "initial"

    // On affiche les numéros des pages dans l'entête
    // On parcourt la liste des pages
    pages.forEach((page, index) => {
        // On crée l'élément "numéro de page"
        let element = document.createElement("div")
        element.classList.add("page-num")
        element.id = "num" + (index + 1)
        if(pageActive === index + 1){
            element.classList.add("active")
        }
        element.innerHTML = index + 1
        header.appendChild(element)
    })

    // On gère les boutons "suivant"
    let boutons = document.querySelectorAll(".next")

    for(let bouton of boutons){
        bouton.addEventListener("click", pageSuivante)
    }

    // On gère les boutons "suivant"
    boutons = document.querySelectorAll(".prev")

    for(let bouton of boutons){
        bouton.addEventListener("click", pagePrecedente)
    }
}

/**
 * Cette fonction fait avancer le formulaire d'une page
 */
function pageSuivante(){
    // On masque toutes les pages
    for(let page of pages){
        page.style.display = "none"
    }

    // On affiche la page suivante
    this.parentElement.nextElementSibling.style.display = "initial"

    // On "désactive" la page active
    document.querySelector(".active").classList.remove("active")

    // On incrémente pageActive
    pageActive++

    // On "active" le nouveau numéro
    document.querySelector("#num"+pageActive).classList.add("active")
}

/**
 * Cette fonction fait reculer le formulaire d'une page
 */
function pagePrecedente(){
    // On masque toutes les pages
    for(let page of pages){
        page.style.display = "none"
    }

    // On affiche la page suivante
    this.parentElement.previousElementSibling.style.display = "initial"

    // On "désactive" la page active
    document.querySelector(".active").classList.remove("active")

    // On incrémente pageActive
    pageActive--

    // On "active" le nouveau numéro
    document.querySelector("#num"+pageActive).classList.add("active")
}