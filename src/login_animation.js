let btnPgLogin = document.getElementById('login'); 
let btnPgCadastro = document.getElementById('voltar'); 
let body = document.querySelector("body");

btnPgLogin.addEventListener("click", function(){
    body.className = "login-js";
});

btnPgCadastro.addEventListener("click", function(){
    body.className = "cv-js";
});