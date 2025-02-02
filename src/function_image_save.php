
<?php

//conexão com o banco
require '../config/conection_db.php';

function deletarImagem() {

    require '../config/conection_db.php';
        $image_id = intval($_GET['deletar']);
        $sql_query = $osdatabase->query("SELECT * FROM tb_image_ativo WHERE image_id = '$image_id'") or die($osdatabase->error);
        $arquivo = $sql_query->fetch_assoc();
        
        if (unlink($arquivo['caminho'])); {
            $funcionou = $osdatabase->query("DELETE FROM tb_image_ativo WHERE image_id = '$image_id'") or die($osdatabase->error);
            if ($funcionou) {
                echo "<p>Arquivo deletado</p>";
            }
        }
    }


//salvando imagens a partir do formulario
function salvarImagem() {
require '../config/conection_db.php';
        //validação do formulario
        $ativoImage = $_FILES['ativo_image'];
        if($ativoImage['error'])
        die("Falha ao enviar a imagem do ativo");
        if($ativoImage['size'] > 3145728)
        die("Arquivo muito grande! Maximo suportado é: 3MB");

        //definindo variaveis de separação de campo
        $pasta = "../../../storage/ordem_servico/ativo-image/";
        $nomeDoArquivo = $ativoImage['name'];
        $nomeNovoDoArquivo = uniqid();
        $extensaoDoArquivo = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
        $caminho = $pasta.$nomeNovoDoArquivo.".". $extensaoDoArquivo;

        if($extensaoDoArquivo != "jpg" && $extensaoDoArquivo != 'png') 
        die ("Tipo de arquivo não aceito");

        //movendo arquivos para a pasta e o banco de dados
        $moverArquivo = move_uploaded_file($ativoImage["tmp_name"], $caminho);
        if($moverArquivo == true ) {
            $osdatabase->query("INSERT INTO tb_image_ativo (nome, caminho, ativo_id) 
            VALUES ('$nomeNovoDoArquivo', '$caminho', $ativo_id)") or die($osdatabase->error);
            echo "<p> Imagem do ativo enviada com seucesso! para acessa-la  
            <a tarket=\"_blank\" href=\"../../../storage/ordem_servico/ativo-image/$nomeNovoDoArquivo.$extensaoDoArquivo\">
            clique aqui</a> </p>";
        } else {
            echo "<p>Erro ao enviar a imagem do ativo</p>";
        }
    }

    ?>