<?php
require "../config/conection_db.php";

function criarOs() {
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
            if(isset($_FILES['ativo_image'])) {
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

            if($extensaoDoArquivo != "jpg" && $extensaoDoArquivo != 'png' && $extensaoDoArquivo != 'jpeg') 
            die ("Tipo de arquivo não aceito");

            //movendo arquivos para a pasta e o banco de dados
            $moverArquivo = move_uploaded_file($ativoImage["tmp_name"], $caminho);
            if($moverArquivo == true ) {
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

}

function editarOs() {
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
            if(isset($_FILES['ativo_image'])) {
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

            if($extensaoDoArquivo != "jpg" && $extensaoDoArquivo != 'png' && $extensaoDoArquivo != 'jpeg') 
            die ("Tipo de arquivo não aceito");

            //movendo arquivos para a pasta e o banco de dados
            $moverArquivo = move_uploaded_file($ativoImage["tmp_name"], $caminho);
            if($moverArquivo == true ) {
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
    header('Location: index.php');
    exit;

}
