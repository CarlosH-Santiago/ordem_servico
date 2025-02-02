<?php 
require "../config/conection_db.php";

function cadastrar() {
    require "../config/conection_db.php";

    
    if(isset($_POST['nome']) || isset($_POST['email']) || isset($_POST['senha'])) {
    
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    
        $stmt = $osdatabase->prepare("INSERT INTO tb_usuario (nome, email, senha) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Erro na preparação da query: " . $conn->error);
        }

        $stmt->bind_param("sss", $nome, $email, $senha);
        if (!$stmt->execute()) {
            die("Erro ao inserir empresa: " . $stmt->error);
        }
        $stmt->close();
    }
}
?>