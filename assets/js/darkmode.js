// inspired by Ryan's svg animation
// https://codepen.io/ryanparag/pen/rNeybEe

const darkMode = document.querySelector(".theme-toggle");

function darkify() {
    document.documentElement.classList.toggle("theme--night");
}

darkMode.addEventListener("click", darkify);

darkify();
