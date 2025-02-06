<?php
    session_start();
    
    // Se o usuário não estiver logado, redireciona para a página de login
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.php");
        exit();
    }
?>
