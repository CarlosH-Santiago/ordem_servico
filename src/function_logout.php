<?php
function logout() {
    session_start();
    session_unset();  // Limpa todas as variáveis da sessão
    session_destroy(); // Destroi a sessão
    header("Location: index.php"); // Redireciona para a página de login
    exit();
}

//Para chamar o logout

//require "function_logout.php";
//logout();
//<a href="logout.php" class="button">Sair</a>



?>


