<?php
require "../config/conection_db.php";
//require "../src/session_verify.php";


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ver - ordem de serviço</title>
    <link rel="stylesheet" href="../assets/library/bootstrap.min.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../styles/os_docs.css" />
</head>

<body>
    <header>
        <?php
        include "../components/header.php";
        ?>
    </header>

    <section class="cvimage"><img src="../assets/image/CV MULTIVARIEDADES_COLOR.png" alt="cvmulitivariedades"></section>

    <main>
        <?php
        if (isset($_GET['os_id'])) {
            $os_id = mysqli_real_escape_string($osdatabase, $_GET['os_id']);
            $sql = "SELECT * FROM ordem_servico_doc WHERE os_id = $os_id";
            $query = mysqli_query($osdatabase, $sql);

            if (mysqli_num_rows($query) > 0) {
                $ordem_servico = mysqli_fetch_array($query);

        ?>
                <form enctype="multipart/form-data" action="" method="post" id="osForm">
                    <input type="hidden" name="os_id" value="<?= $ordem_servico['os_id']; ?>">
                    <div class="imagem">
                        <div class="image-preview" id="image-preview">
                            <img id="previewImage" alt="Imagem do Ativo" src="<?= $ordem_servico['caminho']; ?>" />
                        </div>
                        <label class="ativo_image_input" for="ativo_image"><i class="bi bi-image"></i></label>
                        <input id="ativo_image" type="file" name="ativo_image" />
                        <div class="cvImage">
                            <img class="cvimagem" src="../assets/image/CV MULTIVARIEDADES_COLOR_2.png" alt="cvmulitivariedades" height="100" width="110">
                        </div>
                    </div>

                    <div id="doc-label" class="doc-label">
                        <div class="input-group EMPRESA row mx-1">
                            <h4>EMPRESA RESPONSÁVEL</h4>
                            <label class="a" id="nomeEmpresa" for="nomeEmpresa">Nome</label>
                            <input
                                class="left"
                                type="text"
                                name="nomeEmpresa"
                                id="id_nome"
                                readonly
                                value="<?= $ordem_servico['empresa_nome'] ?? '' ?>" />
                            <label class="b" id="cnpjEmpresa" for="cnpjEmpresa">CNPJ</label>
                            <input
                                class="right"
                                type="text"
                                name="cnpjEmpresa"
                                id="id_cnpjEmpresa"
                                readonly
                                value="<?= $ordem_servico['cnpj'] ?? '' ?>" />
                            <label class="c" id="emailEmpresa" for="email">E-mail</label>
                            <input
                                class="left"
                                type="email"
                                name="emailEmpresa"
                                id="id_email"
                                placeholder="exemple@email.com"
                                readonly
                                value="<?= $ordem_servico['empresa_email'] ?? '' ?>" />
                            <label class="d" id="celularEmpresa" for="celular">Celular/Whatsapp</label>
                            <input
                                class="right"
                                type="tel"
                                name="celularEmpresa"
                                id="id_celular"
                                placeholder="Ex.: +55 (75) 90000-0000"
                                pattern="\(\d{2}\) 9\d{4}-\d{4}"
                                readonly
                                value="<?= $ordem_servico['empresa_telefone'] ?? '' ?>" />
                        </div>

                        <div class="input-group CLIENTE row mx-1">
                            <h4>Cliente</h4>
                            <label class="a" id="nomeCliente" for="nome">Nome</label>
                            <input
                                class="left"
                                type="text"
                                name="nomeCliente"
                                id="id_nome"
                                readonly
                                value="<?= $ordem_servico['cliente_nome'] ?? '' ?>"
                                required />
                            <label class="b" id="cpfcnpjCliente" for="cpfCnpj">CPF/CNPJ</label>
                            <input
                                class="right"
                                type="text"
                                name="cpfCnpj"
                                readonly
                                value="<?= $ordem_servico['cpf_cnpj'] ?? '' ?>"
                                id="id_cpfCnpj" />

                            <label class="c" id="emailCliente" for="Email">E-mail</label>
                            <input
                                class="left"
                                type="email"
                                name="emailCliente"
                                id="id_email"
                                placeholder="exemple@email.com"
                                readonly
                                value="<?= $ordem_servico['cliente_email'] ?? '' ?>" />
                            <label class="d" id="celularCliente" for="celular">Celular/Whatsapp</label>
                            <input
                                class="right"
                                type="tel"
                                name="celularCliente"
                                id="id_celular"
                                placeholder="Ex.: (75) 90000-0000"
                                pattern="\(\d{2}\) 9\d{4}-\d{4}"
                                readonly
                                value="<?= $ordem_servico['cliente_telefone'] ?? '' ?>"
                                required />
                        </div>

                        <div class="input-group ENDERECO row mx-1">
                            <h4>Local</h4>
                            <label class="a" id="endereco" for="endereco">Endereço</label>
                            <input
                                class="left"
                                type="text"
                                name="endereco"
                                id="endereco"
                                placeholder="Rua, Avenida, etc."
                                readonly
                                value="<?= $ordem_servico['endereco'] ?? '' ?>" />
                            <label class="b" id="bairro" for="bairro">Bairro</label>
                            <input
                                class="right"
                                type="text"
                                name="bairro"
                                id="id_bairro"
                                placeholder="Ex.: Centro"
                                readonly
                                value="<?= $ordem_servico['bairro'] ?? '' ?>" />
                            <label class="c" id="cidade" for="cidade">Cidade</label>
                            <input
                                class="left"
                                type="text"
                                name="cidade"
                                id="id_cidade"
                                placeholder="Ex.: Irará"
                                readonly
                                value="<?= $ordem_servico['cidade'] ?? '' ?>" />
                            <label class="CEP" id="CEP" for="CEP">Codigo postal</label>
                            <input
                                id="CEP-i"
                                type="tel"
                                name="CEP"
                                id="id_postal"
                                placeholder="Ex.: 444255-000"
                                readonly
                                value="<?= $ordem_servico['cep'] ?? '' ?>" />
                            <label class="UF" id="UF" for="UF">UF</label>
                            <input
                                id="UF-i"
                                type="text"
                                name="UF"
                                id="id_uf"
                                placeholder="Ex.: BA"
                                readonly
                                value="<?= $ordem_servico['uf'] ?? '' ?>" />
                        </div>

                        <div class="input-group SERVICO row mx-1">
                            <h4>Informações do Serviço</h4>
                            <label class="a" id="chegada" for="horarioDeChegada">Data de Chegada</label>
                            <input
                                class="left"
                                type="date"
                                name="dataDeChegada"
                                readonly
                                value="<?= $ordem_servico['data_chegada'] ?>"
                                id="id_data_chegada" />
                            <label class="b" id="saida" for="horarioDeSaida">Data de Saída</label>
                            <input
                                class="right"
                                type="date"
                                name="dataDeSaida"
                                readonly
                                value="<?= $ordem_servico['data_saida'] ?? ''; ?>"
                                id="id_data_chegada" />
                            <label class="valor" for="valor">Valor R$</label>
                            <input type="text" id="valor" class="currency" placeholder="0,00" readonly
                                value="<?= $ordem_servico['valor'] ?? '' ?>" />
                            <label id="servico" for="servico">Serviço Realizado</label>
                            <textarea
                                class="textarea"
                                name="servico"
                                readonly
                                id="id_servico"><?= $ordem_servico['servico'] ?? '' ?></textarea>
                        </div>

                        <div class="input-group ATIVO row mx-1">
                            <h4>Ativo</h4>
                            <label class="a" id="1" for="nome">Nome</label>
                            <input
                                class="left"
                                type="text"
                                name="nomeAtivo"
                                id="id_ativo"
                                readonly
                                value="<?= $ordem_servico['ativo_nome'] ?? '' ?>" />
                            <label class="b" id="2" for="nome">Marca</label>
                            <input
                                class="right"
                                type="text"
                                name="marca"
                                id="id_marca"
                                readonly
                                value="<?= $ordem_servico['marca'] ?? '' ?>" />
                            <label class="c" id="3" for="nome">Modelo</label>
                            <input
                                class="left"
                                type="text"
                                name="modelo"
                                id="id_modelo"
                                readonly
                                value="<?= $ordem_servico['modelo'] ?? '' ?>" />
                            <label class="d" id="4" for="nome">Patrimônio/Número de Série</label>
                            <input
                                class="right"
                                type="text"
                                name="patrimonio"
                                id="id_patrimonio"
                                readonly
                                value="<?= $ordem_servico['patrimonio'] ?? '' ?>" />
                        </div>
                        <div class="input-group SITUACAO row mx-1">

                            <label for="situacao">Situação da OS:</label>
                            <select name="situacao" id="situacao" readonly
                                value="<?= $ordem_servico['situcao']; ?>">
                                <option value="pendente">Pendente</option>
                                <option value="finalizada">Finalizada</option>
                            </select>
                        </div>
                        <button onclick="return location.href='os_panel.php'" class="btn btn-danger btn-sm mx-1" type="cancel" name="cancel_edit">Cancelar</button>
                    </div>
                </form>
        <?php
            } else {
                header("Location: os_panel.php");
                echo '<h5>Usuário nao encontrado</h5>';
            }
        }
        ?>
    </main>

    <section class="cvimage"><img src="../assets/image/CV MULTIVARIEDADES_COLOR.png" alt="cvmulitivariedades"></section>

    <script src="../assets/library/bootstrap.bundle.min.js"></script>
</body>

</html>