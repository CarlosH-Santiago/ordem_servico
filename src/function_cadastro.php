<?php 
require "../config/conection_db.php";

function cadastrar() {
    require "../config/conection_db.php";

    
    if(isset($_POST['cadNome']) || isset($_POST['cadEmail']) || isset($_POST['cadSenha'])) {
    
        $nome = $_POST['cadNome'];
        $email = $_POST['cadEmail'];
        $senha = password_hash($_POST['cadSenha'], PASSWORD_DEFAULT);
    
        $stmt = $osdatabase->prepare("INSERT INTO tb_usuario (nome, email, senha) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Erro na preparação da query: " . $osdatabase->error);
        }

        $stmt->bind_param("sss", $nome, $email, $senha);
        if (!$stmt->execute()) {
            die("Erro ao inserir empresa: " . $stmt->error);
        }
        $stmt->close();
    }
}
?>