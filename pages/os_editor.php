<?php 
include "../src/function-image-save.phpimage-save.php";
require "../config/conection_db.php";

  if(isset($_FILES['deletar'])) {
    $imagem_id = $GET['deletar'];
    deletarImagem($osdatabase, $imagem_id);
  }

  
  if(isset($_FILES['ativo_image'])) {
    salvarImagem($osdatabase, $_FILES['ativo_image']);
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
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <link rel="stylesheet" href="../styles/header.css" />
    <link rel="stylesheet" href="../styles/os_editor.css" />
  </head>
  <body>
    <header>
      <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img
              src="../assets/image/cvmulti 1.png"
              alt="Logo"
              width="60"
              height="24"
              class="d-inline-block align-text-top"
            />
            <span> MULTI VARIEDADES </span>
          </a>
          <button
            class="navbar-toggler text-bg-dark"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div
            class="offcanvas offcanvas-end"
            tabindex="-1"
            id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel"
          >
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
              ></button>
            </div>
            <div class="offcanvas-body bg-dark">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#"
                    >Home</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    Dropdown
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="#">Action</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">Another action</a>
                    </li>
                    <li>
                      <hr class="dropdown-divider" />
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </li>
                  </ul>
                </li>
              </ul>
              <form class="d-flex mt-3" role="search">
                <input
                  class="form-control me-2"
                  type="search"
                  placeholder="Search"
                  aria-label="Search"
                />
                <button class="btn btn-outline-warning" type="submit">
                  Search
                </button>
              </form>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <section class="cvimage"><img src="../assets/image/CV MULTIVARIEDADES_COLOR.png" alt="cvmulitivariedades"></section>

    <main>
      <form enctype="multipart/form-data" action="" method="post" id="osForm">
        <div class="imagem">
          <div class="image-preview" id="image-preview">
            <img id="previewImage" alt="" />
          </div>
          <label class="ativo_image_input" for="ativo_image"><i class="bi bi-image"></i></label>
          <input  id="ativo_image" type="file" name="ativo_image"/>
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
              value="CV MULTI VARIEDADES"
            />
            <label class="b" id="razaoEmpresa" for="razaoSocial"
              >Razão Social</label
            >
            <input
              class="right"
              type="text"
              name="razaoSocial"
              id="id_razaoSocial"
              required
              value=""
            />
            <label class="c" id="emailEmpresa" for="email">E-mail</label>
            <input
              class="left"
              type="email"
              name="email"
              id="id_email"
              placeholder="exemple@email.com"
              value="cvmultivariedades@hotmail.com"
            />
            <label class="d" id="celularEmpresa" for="celular"
              >Celular/Whatsapp</label
            >
            <input
              class="right"
              type="tel"
              name="celular"
              id="id_celular"
              placeholder="Ex.: +55 (75) 90000-0000"
              pattern="\([0-9]{2}\)[0-9]{4,6}-[0-9]{3,4}$"
              required
              value="+55 (75) 98247-7023"
            />
          </div>

          <div class="input-group CLIENTE row mx-1">
            <h4>Cliente</h4>
            <label class="a" id="nomeCliente" for="nome">Nome</label>
            <input
              class="left"
              type="text"
              name="nomeCliente"
              id="id_nome"
              required
            />
            <label class="b" id="razaoCliente" for="razao">Razão Social</label>
            <input
              class="right"
              type="text"
              name="razaoSocial"
              id="id_razaoSocial"
            />
            <label class="c" id="emailCliente" for="Email">E-mail</label>
            <input
              class="left"
              type="email"
              name="email"
              id="id_email"
              placeholder="exemple@email.com"
            />
            <label class="d" id="celularCliente" for="celular"
              >Celular/Whatsapp</label
            >
            <input
              class="right"
              type="tel"
              name="celular"
              id="id_celular"
              placeholder="Ex.: +55 (75) 90000-0000"
              pattern="\([0-9]{2}\)[0-9]{4,6}-[0-9]{3,4}$"
              required
            />
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
              required
            />
            <label class="b" id="bairro" for="bairro">Bairro</label>
            <input
              class="right"
              type="text"
              name="bairro"
              id="id_bairro"
              placeholder="Ex.: Centro"
              required
            />
            <label class="c" id="cidade" for="cidade">Cidade</label>
            <input
              class="left"
              type="text"
              name="cidade"
              id="id_cidade"
              placeholder="Ex.: Irará"
              required
            />
            <label class="postal" id="postal" for="postal">Codigo postal</label>
            <input
              id="postal-i"
              type="tel"
              name="postal"
              id="id_postal"
              placeholder="Ex.: 444255-000"
              required
            />
            <label class="UF" id="UF" for="UF">UF</label>
            <input
              id="UF-i"
              type="text"
              name="UF"
              id="id_uf"
              placeholder="Ex.: BA"
              required
            />
          </div>

          <div class="input-group SERVICO row mx-1">
            <h4>Informações do Serviço</h4>
            <label class="a" id="chegada" for="horarioDeChegada"
              >Horário de Chegada</label
            >
            <input
              class="left"
              type="date"
              name="horarioDeChegada"
              id="id_hora_chegada"
              required
            />
            <label class="b" id="saida" for="horarioDeSaida"
              >Horário de Saída</label
            >
            <input
              class="right"
              type="date"
              name="horarioDeSaida"
              id="id_hora_chegada"
              required
            />
            <label class="valor" for="valor">Valor</label>
            <p class="BRL">R$</p>
            <input type="text" id="valor" class="currency" placeholder="0,00" />
            <label id="servico" for="servico">Serviço Realizado</label>
            <textarea
              class="textarea"
              name="servico"
              id="id_servico"
            ></textarea>
          </div>

          <div class="input-group ATIVO row mx-1">
            <h4>Ativo</h4>
            <label class="a" id="1" for="nome">Nome</label>
            <input
              class="left"
              type="text"
              name="nomeAtivo"
              id="id_ativo"
              required
            />
            <label class="b" id="2" for="nome">Marca</label>
            <input
              class="right"
              type="text"
              name="marca"
              id="id_marca"
              required
            />
            <label class="c" id="3" for="nome">Modelo</label>
            <input
              class="left"
              type="text"
              name="modelo"
              id="id_modelo"
              required
            />
            <label class="d" id="4" for="nome"
              >Patrimônio/Número de Série</label
            >
            <input
              class="right"
              type="text"
              name="patrimonio"
              id="id_patrimonio"
              required
            />
          </div>

          <button type="submit">Salvar</button>
        </div>
      </form>
    </main>
    
    <section class="cvimage"><img src="../assets/image/CV MULTIVARIEDADES_COLOR.png" alt="cvmulitivariedades"></section>

    <script src="../assets/library/bootstrap.bundle.min.js"></script>
  </body>
</html>
