<?php 
require "../config/conection_db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_os'])) {
    $os_id = $_POST['delete_os'];

    // Inicia a transação
    $osdatabase->begin_transaction();

    try {
        // 1️⃣ Excluir imagem associada ao ativo
        $queryImagem = "SELECT caminho FROM tb_image_ativo WHERE ativo_id = (SELECT ativo_id FROM tb_ordem_servico WHERE os_id = ?)";
        $stmtImagem = $osdatabase->prepare($queryImagem);
        $stmtImagem->bind_param("i", $os_id);
        $stmtImagem->execute();
        $resultImagem = $stmtImagem->get_result();
        if ($row = $resultImagem->fetch_assoc()) {
            $caminhoImagem = $row['caminho'];
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem); // Remove o arquivo físico
            }
        }
        $stmtImagem->close();

        // 2️⃣ Excluir a OS e os dados relacionados (graças ao ON DELETE CASCADE)
        $stmt = $osdatabase->prepare("DELETE FROM tb_ordem_servico WHERE os_id = ?");
        $stmt->bind_param("i", $os_id);
        $stmt->execute();
        $stmt->close();

        $osdatabase->commit(); // Confirma a exclusão
        header("Location: os_panel.php?"); // Redireciona com mensagem de sucesso
        exit;
    } catch (Exception $e) {
        $osdatabase->rollback(); // Reverte alterações em caso de erro
        die("Erro ao excluir: " . $e->getMessage());
    }
}
?>
