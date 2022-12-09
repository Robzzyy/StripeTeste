/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)



import { StringMapObserver } from "@hotwired/stimulus";
import "./styles/app.scss";


// start the Stimulus application
// import "./bootstrap";

const $ = require("jquery");
global.$ = global.jQuery = $;
require("bootstrap");

$(() => {
    // requete ajax pour le nombre d'article qui s'ajoute en haut du panier
    $("a.ajax").on("click", (evtClick) => {
        evtClick.preventDefault();
        var href = evtClick.target.getAttribute("href");
        console.log(href);
        $.ajax({
            url: href,
            dataType: "json",
            success: (data) => {
                $("#nombre").html(data);
                console.log(data);
            },
            error: (jqXHR, status, error) => {
                console.log("ERREUR AJAX", status, error);
            },
        });
    });

    // requete ajax pour le bouton de recherche de la nav
    $("#formSearch").on("submit", (evtSubmit) => {
        evtSubmit.preventDefault();
        $.ajax({
            url: evtSubmit.target.getAttribute("action"),
            data: "search=" + $("#formSearch #search").val(),
            dataType: "html",
            success: (data) => {
                $("#main").html(data);
            },
            error: (jqXHR, status, error) => {
                console.log("ERREUR AJAX", status, error);
            },
        });
    });
});


const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});




    //   src="https://kit.fontawesome.com/64d58efce2.js"
    //   crossorigin="anonymous"
   


var stripe = Stripe('pk_test_51MCO9kIrtTbTVe0JdnCwCMGmHaIgOOkhwC44y24XnvN3zbLlSNyjjaIczow6nTdEEJPHv2wdj88hOBO7PmMqyVsG006R3KaX2H');
var elements = stripe.elements();