<?php 
require "../config/conection_db.php";

function logar() {
    require "../config/conection_db.php";

    
    if(isset($_POST['logEmail']) || isset($_POST['logSenha'])) {
    
        $email = $_POST['logEmail'];
        $senha = $_POST['logSenha'];
    
        $stmt = $osdatabase->prepare("SELECT * FROM tb_usuario WHERE email = ? LIMIT 1");
        if (!$stmt) {
            die("Erro na preparação da query: " . $osdatabase->error);
        }
        $stmt->bind_param("s",  $email);
        if (!$stmt->execute()) {
            die("Erro ao inserir empresa: " . $stmt->error);
        }

        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $usurio = $result->fetch_assoc();

            if (password_verify($senha, $usurio['senha'])) {
                session_start();
                $_SESSION['usuario_id'] = $usurio['usuario_id'];
                $_SESSION['usuario_nome'] = $usurio['nome'];
                echo "<div class=\"alert alert-success\" role=\"alert\">Login bem-sucedido! Bem-vindo, " . $_SESSION['usuario_nome'] . "</div>";
                
                // Redirecionamento após login bem-sucedido
                header("Location: ../pages/os_pannel.html"); 
                exit();
            } else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">Senha incorreta!</div>";
            }
        } else {
            echo "<div class=\"alert alert-danger\" role=\"alert\">Usuário não encontrado!</div>";
        }

        $stmt->close();
    } else {
        echo "<div class=\"alert alert-warning\" role=\"alert\">Preencha todos os campos!</div>";
    }
}


?>