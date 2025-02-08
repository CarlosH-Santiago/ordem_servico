<?php 
require "../config/conection_db.php";
include "../src/function_login.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  logar();
}

?>


<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CV MULTIVARIEDADES</title>
    <link rel="stylesheet" href="../library/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <link rel="stylesheet" href="../styles/Login.css" />
  </head>
  <body class="">
    <div class="contain">
      <div class="content">
        <div class="first-content">
          <div class="first-column">
            <h2 class="title-a">Seja Bem vindo de Volta</h2>
            <p class="descricao-primary">Para se conectar novamente</p>
            <p class="descricao-primary">Por favor faça login com sua conta</p>
            <button id="login" class="button button-primary">LOGIN</button>
          </div>
          <!-- fim first column-->
          <div class="second-column">
            <h2 class="title-OS">Ordens de Serviço</h2>
            <img src="../assets/image/CVMULTVARIEDADES_SVG 1.svg" width="400" alt="CV MULTIVARIEDADES">
          </div>
          <!-- fim second column-->
        </div>
        <!-- fim first content-->

        <div class="second-content">
          <div class="first-column">
            <h2 class="title-a">Ordens de Serviço!</h2>
            <img src="../assets/image/CV MULTIVARIEDADES_COLOR.png" width="300" alt="CV MULTIVARIEDADES">
            <button id="voltar" class="button button-primary">Voltar</button>
          </div>
          <!-- fim first column-->
          <div class="second-column">
            <h2 class="title-b">Logando Conta</h2>
            <p class="descricao-second"></p>
            <form action="" method="post" class="form">
              <label class="label-input" for="cadEmail">
                <i class="bi bi-envelope icon-modify"></i>
                <input
                  type="email"
                  name="logEmail"
                  id="logEmail"
                  placeholder="Email"
                />
              </label>
              <label class="label-input" for="cadSenha">
                <i class="bi bi-lock icon-modify"></i>
                <input
                  type="password"
                  name="logSenha"
                  id="logSenha"
                  placeholder="Senha"
                />
                <i class="bi bi-eye" id="btn-showPass" onclick="showPasswordL()"></i>
              </label>

              <a href="#" class="password">Esqueceu sua senha?</a>
              <button type="submit" class="button button-second">LOGIN</button>
            </form>
          </div>
          <!-- fim second column-->
        </div>
        <!-- fim second content-->
      </div>
      <!-- fim content-->
    </div>
    <!-- fim  container-->
  </body>
  <script src="../library/bootstrap.bundle.min.js"></script>
  <script src="../src/login_animation.js"></script>
  <script src="../src/function_show_password.js"></script>
</html>
