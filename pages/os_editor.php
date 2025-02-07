<?php
include "../src/function_save_ordem_servico.php";
require "../config/conection_db.php";
//require "../src/session_verify.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  salvarOs();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Editor de ordem de serviço</title>
  <link rel="stylesheet" href="../assets/library/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="../styles/header.css" />
  <link rel="stylesheet" href="../styles/ordem_servico_editor.css" />
</head>

<body>
  <header>
<?php 
include "../components/header.php";
?>
  </header>

  <section class="cvimage"><img src="../assets/image/CV MULTIVARIEDADES_COLOR.png" alt="cvmulitivariedades"></section>

  <main>
    <form enctype="multipart/form-data" action="" method="post" id="osForm">
      <div class="imagem">
        <div class="image-preview" id="image-preview">
          <img id="previewImage" alt="" />
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
            required
            value="CV MULTI VARIEDADES" />
          <label class="b" id="cnpjEmpresa" for="cnpjEmpresa">CNPJ</label>
          <input
            class="right"
            type="text"
            name="cnpjEmpresa"
            id="id_cnpjEmpresa"
            required
            value="36.070.021/0001-20" />
          <label class="c" id="emailEmpresa" for="email">E-mail</label>
          <input
            class="left"
            type="email"
            name="emailEmpresa"
            id="id_email"
            placeholder="exemple@email.com"
            value="cvmultivariedades@hotmail.com" />
          <label class="d" id="celularEmpresa" for="celular">Celular/Whatsapp</label>
          <input
            class="right"
            type="tel"
            name="celularEmpresa"
            id="id_celular"
            placeholder="Ex.: +55 (75) 90000-0000"
            pattern="\(\d{2}\) 9\d{4}-\d{4}"
            required
            value="(75) 98247-7023" />
        </div>

        <div class="input-group CLIENTE row mx-1">
          <h4>Cliente</h4>
          <label class="a" id="nomeCliente" for="nome">Nome</label>
          <input
            class="left"
            type="text"
            name="nomeCliente"
            id="id_nome"
            required />
          <label class="b" id="cpfcnpjCliente" for="cpfCnpj">CPF/CNPJ</label>
          <input
            class="right"
            type="text"
            name="cpfCnpj"
            id="id_cpfCnpj" />
          <label class="c" id="emailCliente" for="Email">E-mail</label>
          <input
            class="left"
            type="email"
            name="emailCliente"
            id="id_email"
            placeholder="exemple@email.com" />
          <label class="d" id="celularCliente" for="celular">Celular/Whatsapp</label>
          <input
            class="right"
            type="tel"
            name="celularCliente"
            id="id_celular"
            placeholder="Ex.: (75) 90000-0000"
            pattern="\(\d{2}\) 9\d{4}-\d{4}"
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
            required />
          <label class="b" id="bairro" for="bairro">Bairro</label>
          <input
            class="right"
            type="text"
            name="bairro"
            id="id_bairro"
            placeholder="Ex.: Centro"
            required />
          <label class="c" id="cidade" for="cidade">Cidade</label>
          <input
            class="left"
            type="text"
            name="cidade"
            id="id_cidade"
            placeholder="Ex.: Irará"
            required />
          <label class="CEP" id="CEP" for="CEP">Codigo postal</label>
          <input
            id="CEP-i"
            type="tel"
            name="CEP"
            id="id_postal"
            placeholder="Ex.: 444255-000"
            required />
          <label class="UF" id="UF" for="UF">UF</label>
          <input
            id="UF-i"
            type="text"
            name="UF"
            id="id_uf"
            placeholder="Ex.: BA"
            required />
        </div>

        <div class="input-group SERVICO row mx-1">
          <h4>Informações do Serviço</h4>
          <label class="a" id="chegada" for="horarioDeChegada">Horário de Chegada</label>
          <input
            class="left"
            type="date"
            name="dataDeChegada"
            id="id_data_chegada"
            />
          <label class="b" id="saida" for="horarioDeSaida">Horário de Saída</label>
          <input
            class="right"
            type="date"
            name="dataDeSaida"
            id="id_data_chegada"
          />
          <label class="valor" for="valor">Valor</label>
          <p class="BRL">R$</p>
          <input type="text" id="valor" class="currency" placeholder="0,00" />
          <label id="servico" for="servico">Serviço Realizado</label>
          <textarea
            class="textarea"
            name="servico"
            id="id_servico"></textarea>
        </div>

        <div class="input-group ATIVO row mx-1">
          <h4>Ativo</h4>
          <label class="a" id="1" for="nome">Nome</label>
          <input
            class="left"
            type="text"
            name="nomeAtivo"
            id="id_ativo"
            required />
          <label class="b" id="2" for="nome">Marca</label>
          <input
            class="right"
            type="text"
            name="marca"
            id="id_marca"
            required />
          <label class="c" id="3" for="nome">Modelo</label>
          <input
            class="left"
            type="text"
            name="modelo"
            id="id_modelo"
            required />
          <label class="d" id="4" for="nome">Patrimônio/Número de Série</label>
          <input
            class="right"
            type="text"
            name="patrimonio"
            id="id_patrimonio"
            required />
        </div>
        <div class="input-group SITUACAO row mx-1">

        <label for="situacao">Situação da OS:</label>
        <select name="situacao" id="situacao">
          <option value="pendente">Pendente</option>
          <option value="finalizada">Finalizada</option>
        </select>
        </div>
      <button type="submit">Salvar</button>

      </div>
    </form>
  </main>

  <section class="cvimage"><img src="../assets/image/CV MULTIVARIEDADES_COLOR.png" alt="cvmulitivariedades"></section>

  <script src="../assets/library/bootstrap.bundle.min.js"></script>
</body>

</html>