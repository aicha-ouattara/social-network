// On va chercher les différents éléments de notre page
const pages = document.querySelectorAll(".page")
const header = document.querySelector(".header-addpost")
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





//DROP OR CLICK
const dropZone = document.querySelector('#drop-zone');
const inputElement = document.querySelector('input');
const img = document.querySelector('img');
let p = document.querySelector('p')

inputElement.addEventListener('change', function (e) {
    const clickFile = this.files[0];
    if (clickFile) {
        img.style = "display:block;";
        p.style = 'display: none';
        const reader = new FileReader();
        reader.readAsDataURL(clickFile);
        reader.onloadend = function () {
            const result = reader.result;
            let src = this.result;
            img.src = src;
            img.alt = clickFile.name
        }
    }
})
dropZone.addEventListener('click', () => inputElement.click());
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
});
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    img.style = "display:block;";
    let file = e.dataTransfer.files[0];

    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onloadend = function () {
        e.preventDefault()
        p.style = 'display: none';
        let src = this.result;
        img.src = src;
        img.alt = file.name
    }
});