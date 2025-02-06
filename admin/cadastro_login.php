<?php 
require "../config/conection_db.php";
include "../src/function_cadastro.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  cadastrar();
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
    <link rel="stylesheet" href="../styles/cadastro__login.css" />
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
            <h2 class="title-b">Crie sua Conta</h2>
            <div class="social-midia">
              <img src="../assets/image/CV MULTIVARIEDADES_COLOR_2.png" width="100" alt="CV MULTIVARIEDADES">
            </div>
            <!-- fim social midia-->
            <p class="descricao-second">Use seu email para se cadastrar</p>
            <form action="" method="post" id="cadastroForm" class="form">
              <label class="label-input" for="cadNome">
                <i class="bi bi-person icon-modify"></i>
                <input
                  type="text"
                  name="cadNome"
                  id="cadNome"
                  placeholder="Nome"
                />
              </label>
              <label class="label-input" for="cadEmail">
                <i class="bi bi-envelope icon-modify"></i>
                <input
                  type="email"
                  name="cadEmail"
                  id="cadEmail"
                  placeholder="Email"
                />
              </label>
              <label class="label-input" for="cadSenha">
                <i class="bi bi-lock icon-modify"></i>
                <input
                  type="password"
                  name="cadSenha"
                  id="cadSenha"
                  placeholder="Senha"
                />
                <i class="bi bi-eye" id="btn-showPass" onclick="showPassword()"></i>
              </label>
              <label class="label-input" for="cadSenhaConf">
                <i class="bi bi-lock icon-modify"></i>
                <input
                  type="password"
                  name="cadSenhaConf"
                  id="cadSenhaConf"
                  placeholder="Confirme a Senha"
                />
                <i class="bi bi-eye" id="btn-showPassConfirm" onclick="showPassConfirm()"></i>
              </label>

              <button type="submit" class="button button-second">
                CADASTRAR
              </button>
            </form>
          </div>
          <!-- fim second column-->
        </div>
        <!-- fim first content-->

        <div class="second-content">
          <div class="first-column">
            <h2 class="title-a">Olá, amigo!</h2>
            <p class="descricao-primary">Primera vez por aqui?</p>
            <p class="descricao-primary">Por favor crie um conta</p>
            <button id="cadastro" class="button button-primary">CADASTRAR</button>
          </div>
          <!-- fim first column-->
          <div class="second-column">
            <h2 class="title-b">Logando Conta</h2>
            <div class="social-midia">
                    <img src="../assets/image/CV MULTIVARIEDADES_COLOR_2.png" width="200" alt="CV MULTIVARIEDADES">
            </div>
            <!-- fim social midia-->
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
  <script src="../src/cadastro_login-animation.js"></script>
  <script src="../src/function_confirm_pass.js"></script>
  <script src="../src/function_show_password.js"></script>
</html>
