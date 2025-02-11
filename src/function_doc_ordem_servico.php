<?php
require "../config/conection_db.php";

function criarOs()
{
    require "../config/conection_db.php";

    //obtendo dados do formulario
    //obtendo dados da empresa
    $nomeEmpresa = isset($_POST['nomeEmpresa']) ? $_POST['nomeEmpresa'] : '';
    $cnpjEmpresa = isset($_POST['cnpjEmpresa']) ? $_POST['cnpjEmpresa'] : '';
    $emailEmpresa = isset($_POST['emailEmpresa']) ? $_POST['emailEmpresa'] : '';
    $celularEmpresa = isset($_POST['celularEmpresa']) ? $_POST['celularEmpresa'] : '';

    //obtendo dados do cliente
    $nomeCliente = isset($_POST['nomeCliente']) ? $_POST['nomeCliente'] : '';
    $cpf_cnpjCliente = isset($_POST['cpfCnpj']) ? $_POST['cpfCnpj'] : '';
    $emailCliente = isset($_POST['emailCliente']) ? $_POST['emailCliente'] : '';
    $celularCliente = isset($_POST['celularCliente']) ? $_POST['celularCliente'] : '';

    //obtendo dados do local do cliente
    $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : '';
    $bairro = isset($_POST['bairro']) ? $_POST['bairro'] : '';
    $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
    $CEP = isset($_POST['CEP']) ? $_POST['CEP'] : '';
    $UF = isset($_POST['UF']) ? $_POST['UF'] : '';

    //obtendo dados do servço
    $dataChegada = isset($_POST['dataDeChegada']) ? $_POST['dataDeChegada'] : ''; // Corrigido o nome
    $dataSaida = isset($_POST['dataDeSaida']) ? $_POST['dataDeSaida'] : ''; // Corrigido o nome
    $servico = isset($_POST['servico']) ? $_POST['servico'] : '';
    $valor = isset($_POST['valor']) ? str_replace(',', '.', $_POST['valor']) : '0.00';
    $situacao = isset($_POST['situacao']) ? $_POST['situacao'] : '';

    //obtendo dados dom ativo
    $nomeAtivo = isset($_POST['nomeAtivo']) ? $_POST['nomeAtivo'] : '';
    $marca = isset($_POST['marca']) ? $_POST['marca'] : '';
    $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';
    $patrimonio = isset($_POST['patrimonio']) ? $_POST['patrimonio'] : '';

    //fazendo as inserções no banco de dados
    try {


        $osdatabase->begin_transaction();

        // Verificar se a empresa já existe
        $stmt = $osdatabase->prepare("SELECT empresa_id FROM tb_empresa_responsavel WHERE cnpj = ?");
        $stmt->bind_param("s", $cnpjEmpresa);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($empresa_id);
            $stmt->fetch();
            $stmt->close();
        } else {
            $stmt->close();
            $stmt = $osdatabase->prepare("INSERT INTO tb_empresa_responsavel (nome_fantasia, cnpj, email, telefone) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                die("Erro na preparação: " . $osdatabase->error);
            }
            $stmt->bind_param("ssss", $nomeEmpresa, $cnpjEmpresa, $emailEmpresa, $celularEmpresa);
            if (!$stmt->execute()) {
                die("Erro ao inserir empresa: " . $stmt->error);
            }
            $empresa_id = $osdatabase->insert_id;
            $stmt->close();
        }


        //inserções do cliente
        $stmt = $osdatabase->prepare("INSERT INTO tb_cliente (nome, cpf_cnpj, email, telefone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nomeCliente, $cpf_cnpjCliente, $emailCliente, $celularCliente);
        $stmt->execute();
        $cliente_id = $osdatabase->insert_id;
        $stmt->close();

        //incerções local
        $stmt = $osdatabase->prepare("INSERT INTO tb_endereco (endereco, bairro, cidade, cep, uf, cliente_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $endereco, $bairro, $cidade, $CEP, $UF, $cliente_id);
        $stmt->execute();
        $endereco_id = $osdatabase->insert_id;
        $stmt->close();

        //inserções do ativo
        $stmt = $osdatabase->prepare("INSERT INTO tb_ativo (nome, marca, modelo, patrimonio, cliente_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nomeAtivo, $marca, $modelo, $patrimonio, $cliente_id);
        $stmt->execute();
        $ativo_id = $osdatabase->insert_id;
        $stmt->close();

        //Inserções do serviço
        $stmt = $osdatabase->prepare("INSERT INTO tb_ordem_servico (empresa_id, cliente_id, ativo_id, situacao, data_chegada, data_saida, servico, valor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $empresa_id, $cliente_id, $ativo_id, $situacao, $dataChegada, $dataSaida, $servico, $valor);
        $stmt->execute();
        $os_id = $osdatabase->insert_id;
        $stmt->close();

        //Incerção da imagem
        //validação do formulario
        if (isset($_FILES['ativo_image'])) {
            $ativoImage = $_FILES['ativo_image'];
            if ($ativoImage['error'])
                die("Falha ao enviar a imagem do ativo");
            if ($ativoImage['size'] > 3145728)
                die("Arquivo muito grande! Maximo suportado é: 3MB");

            //definindo variaveis de separação de campo
            $pasta = "../../../storage/ordem_servico/ativo-image/";
            $nomeDoArquivo = $ativoImage['name'];
            $nomeNovoDoArquivo = uniqid();
            $extensaoDoArquivo = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
            $caminho = $pasta . $nomeNovoDoArquivo . "." . $extensaoDoArquivo;

            if ($extensaoDoArquivo != "jpg" && $extensaoDoArquivo != 'png' && $extensaoDoArquivo != 'jpeg')
                die("Tipo de arquivo não aceito");

            //movendo arquivos para a pasta e o banco de dados
            $moverArquivo = move_uploaded_file($ativoImage["tmp_name"], $caminho);
            if ($moverArquivo == true) {
                $osdatabase->query("INSERT INTO tb_image_ativo (nome, caminho, ativo_id) 
                VALUES ('$nomeNovoDoArquivo', '$caminho', $ativo_id)") or die($osdatabase->error);
            } else {
                echo "<p>Erro ao enviar a imagem do ativo</p>";
            }
        }

        $osdatabase->commit();
    } catch (Exception $e) {
        $osdatabase->rollback();
    }
    header('Location: os_panel.php');
    exit;
}

function editarOs()
{
    require "../config/conection_db.php";

    //obtendo dados do formulario
    //obtendo dados da empresa
    $empresa_id = isset($_POST['empresa_id']) ? $_POST['empresa_id'] : '';
    $nomeEmpresa = isset($_POST['nomeEmpresa']) ? $_POST['nomeEmpresa'] : '';
    $cnpjEmpresa = isset($_POST['cnpjEmpresa']) ? $_POST['cnpjEmpresa'] : '';
    $emailEmpresa = isset($_POST['emailEmpresa']) ? $_POST['emailEmpresa'] : '';
    $celularEmpresa = isset($_POST['celularEmpresa']) ? $_POST['celularEmpresa'] : '';
    
    //obtendo dados do cliente
    $cliente_id = isset($_POST['cliente_id']) ? $_POST['cliente_id'] : '';
    $nomeCliente = isset($_POST['nomeCliente']) ? $_POST['nomeCliente'] : '';
    $cpf_cnpjCliente = isset($_POST['cpfCnpj']) ? $_POST['cpfCnpj'] : '';
    $emailCliente = isset($_POST['emailCliente']) ? $_POST['emailCliente'] : '';
    $celularCliente = isset($_POST['celularCliente']) ? $_POST['celularCliente'] : '';
    
    //obtendo dados do local do cliente
    $endereco_id = isset($_POST['endereco_id']) ? $_POST['endereco_id'] : '';
    $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : '';
    $bairro = isset($_POST['bairro']) ? $_POST['bairro'] : '';
    $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
    $CEP = isset($_POST['CEP']) ? $_POST['CEP'] : '';
    $UF = isset($_POST['UF']) ? $_POST['UF'] : '';
    
    //obtendo dados do servço
    $os_id = isset($_POST['os_id']) ? $_POST['os_id'] : '';
    $dataChegada = isset($_POST['dataDeChegada']) ? $_POST['dataDeChegada'] : ''; // Corrigido o nome
    $dataSaida = isset($_POST['dataDeSaida']) ? $_POST['dataDeSaida'] : ''; // Corrigido o nome
    $servico = isset($_POST['servico']) ? $_POST['servico'] : '';
    $valor = isset($_POST['valor']) ? str_replace(',', '.', $_POST['valor']) : '0.00';
    $situacao = isset($_POST['situacao']) ? $_POST['situacao'] : '';
    
    //obtendo dados dom ativo
    $ativo_id = isset($_POST['ativo_id']) ? $_POST['ativo_id'] : '';
    $nomeAtivo = isset($_POST['nomeAtivo']) ? $_POST['nomeAtivo'] : '';
    $marca = isset($_POST['marca']) ? $_POST['marca'] : '';
    $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';
    $patrimonio = isset($_POST['patrimonio']) ? $_POST['patrimonio'] : '';
    
    $image_id = isset($_POST['image_id']) ? $_POST['image_id'] : '';
    //fazendo as inserções no banco de dados
    try {


        //inserções da empresa
        $stmt = $osdatabase->prepare("UPDATE tb_empresa_responsavel SET nome_fantasia = ? , cnpj = ? , email = ? , telefone = ?  WHERE empresa_id = ?");
        $stmt->bind_param("ssssi", $nomeEmpresa, $cnpjEmpresa, $emailEmpresa, $celularEmpresa, $empresa_id);
        if (!$stmt->execute()) {
            die("Erro ao inserir empresa: " . $stmt->error);
        }
        $stmt->close();

        //inserções do cliente
        $stmt = $osdatabase->prepare("UPDATE tb_cliente SET nome = ?, cpf_cnpj = ?, email = ?, telefone = ? WHERE cliente_id = ?");
        $stmt->bind_param("ssssi", $nomeCliente, $cpf_cnpjCliente, $emailCliente, $celularCliente, $cliente_id);
        $stmt->execute();
        $stmt->close();

        //incerções local
        $stmt = $osdatabase->prepare("UPDATE tb_endereco SET endereco = ?, bairro = ?, cidade = ?, cep = ?, uf = ?, cliente_id = ? WHERE endereco_id = ?");
        $stmt->bind_param("ssssssi", $endereco, $bairro, $cidade, $CEP, $UF, $cliente_id, $endereco_id);
        $stmt->execute();
        $stmt->close();

        //inserções do ativo
        $stmt = $osdatabase->prepare("UPDATE tb_ativo SET nome = ?, marca = ?, modelo = ?, patrimonio = ?, cliente_id = ? WHERE ativo_id = ?");
        $stmt->bind_param("sssssi", $nomeAtivo, $marca, $modelo, $patrimonio, $cliente_id, $ativo_id);
        $stmt->execute();
        $stmt->close();

        //Inserções do serviço
        $stmt = $osdatabase->prepare("UPDATE tb_ordem_servico SET empresa_id = ?, cliente_id = ?, ativo_id = ?, situacao = ?, data_chegada = ?, data_saida = ?, servico = ?, valor = ? WHERE os_id = ?");
        $stmt->bind_param("ssssssssi", $empresa_id, $cliente_id, $ativo_id, $situacao, $dataChegada, $dataSaida, $servico, $valor, $os_id);
        $stmt->execute();
        $stmt->close();

        //Incerção da imagem
        //validação do formulario
        // **Excluir imagem antiga antes de salvar a nova**
        if (isset($_FILES['ativo_image']) && $_FILES['ativo_image']['error'] == 0) {
            // Buscar o caminho da imagem antiga no banco
            $stmt = $osdatabase->prepare("SELECT caminho FROM tb_image_ativo WHERE image_id = ?");
            $stmt->bind_param("i", $image_id);
            $stmt->execute();
            $stmt->bind_result($caminhoImagemAntiga);
            $stmt->fetch();
            $stmt->close();

            // Se a imagem antiga existir no storage, exclui
            if (!empty($caminhoImagemAntiga) && file_exists($caminhoImagemAntiga)) {
                unlink($caminhoImagemAntiga);
            }

            // **Salvar a nova imagem**
            $ativoImage = $_FILES['ativo_image'];

            if ($ativoImage['size'] > 3145728) {
                die("Arquivo muito grande! Máximo suportado é: 3MB");
            }

            $pasta = "../../../storage/ordem_servico/ativo-image/";
            $nomeDoArquivo = $ativoImage['name'];
            $nomeNovoDoArquivo = uniqid();
            $extensaoDoArquivo = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
            $caminho = $pasta . $nomeNovoDoArquivo . "." . $extensaoDoArquivo;

            if (!in_array($extensaoDoArquivo, ["jpg", "jpeg", "png"])) {
                die("Tipo de arquivo não aceito");
            }

            // Move a nova imagem
            if (move_uploaded_file($ativoImage["tmp_name"], $caminho)) {
                // Atualiza o banco de dados com a nova imagem
                $stmt = $osdatabase->prepare("UPDATE tb_image_ativo SET nome = ?, caminho = ?, ativo_id = ? WHERE image_id = ?");
                $stmt->bind_param("sssi", $nomeNovoDoArquivo, $caminho, $ativo_id, $image_id);
                $stmt->execute();
                $stmt->close();
            } else {
                die("Erro ao enviar a imagem do ativo");
            }
        }

        $osdatabase->commit();
    } catch (Exception $e) {
        $osdatabase->rollback();
        die("Erro ao atualizar OS: " . $e->getMessage());
    }
    header('Location: os_panel.php');
    exit;
}


function excluirOs($os_id)
{
    require "../config/conection_db.php";

    try {
        $osdatabase->begin_transaction();

        // 1️⃣ Buscar a imagem associada antes de deletar
        $stmt = $osdatabase->prepare("SELECT caminho FROM tb_image_ativo WHERE ativo_id = (SELECT ativo_id FROM tb_ordem_servico WHERE os_id = ?)");
        $stmt->bind_param("i", $os_id);
        $stmt->execute();
        $stmt->bind_result($caminhoImagem);
        $stmt->fetch();
        $stmt->close();

        // 2️⃣ Excluir a imagem do servidor (se existir)
        if (!empty($caminhoImagem) && file_exists($caminhoImagem)) {
            unlink($caminhoImagem);
        }

        // 3️⃣ Excluir registros relacionados no banco
        $stmt = $osdatabase->prepare("DELETE FROM tb_image_ativo WHERE ativo_id = (SELECT ativo_id FROM tb_ordem_servico WHERE os_id = ?)");
        $stmt->bind_param("i", $os_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $osdatabase->prepare("DELETE FROM tb_ordem_servico WHERE os_id = ?");
        $stmt->bind_param("i", $os_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $osdatabase->prepare("DELETE FROM tb_ativo WHERE ativo_id = (SELECT ativo_id FROM tb_ordem_servico WHERE os_id = ?)");
        $stmt->bind_param("i", $os_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $osdatabase->prepare("DELETE FROM tb_endereco WHERE endereco_id = (SELECT endereco_id FROM tb_cliente WHERE cliente_id = (SELECT cliente_id FROM tb_ordem_servico WHERE os_id = ?))");
        $stmt->bind_param("i", $os_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $osdatabase->prepare("DELETE FROM tb_cliente WHERE cliente_id = (SELECT cliente_id FROM tb_ordem_servico WHERE os_id = ?)");
        $stmt->bind_param("i", $os_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $osdatabase->prepare("DELETE FROM tb_empresa_responsavel WHERE empresa_id = (SELECT empresa_id FROM tb_ordem_servico WHERE os_id = ?)");
        $stmt->bind_param("i", $os_id);
        $stmt->execute();
        $stmt->close();

        $osdatabase->commit();
        echo "Ordem de serviço excluída com sucesso!";
    } catch (Exception $e) {
        $osdatabase->rollback();
        die("Erro ao excluir OS: " . $e->getMessage());
    }
}