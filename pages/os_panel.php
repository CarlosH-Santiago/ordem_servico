<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Painel de Ordens de Serviço</title>
    <link rel="stylesheet" href="../assets/library/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <link rel="stylesheet" type="text/css" href="../styles/os_panel.css" />
  </head>
  <body>
    <header>
  <?php 
  include "../components/header.php";
  ?>
</header>

    <main>
        <div class="container text-center"></div>
        <div class="row gy-3 align-items-center mx-2 row-cols-1 row-cols-md-2 row-cols-lg-4">
            <div class="OrdemServico col">
                Ordem 
                <div class="endereco"></div>
                <div class="data-chegada"></div>
                <div class="ativo"></div>
                <div class="situacao"></div>
            </div>

        </div>
    </main>
  </body>
  <script src="../assets/library/bootstrap.bundle.min.js"></script>
</html>
