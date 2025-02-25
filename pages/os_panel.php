<?php

require "../config/conection_db.php";
//require "../src/session_verify.php";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Painel de Ordens de Serviço</title>
  <link rel="stylesheet" href="../assets/library/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
  <link rel="stylesheet" type="text/css" href="../styles/panel.css" />
</head>

<body>
  <header>
    <?php
    include "../components/header.php";
    ?>
  </header>

  <main>
    <div class="container text-center "></div>
    <div class="row">
      <div class="col-md-12">
        <div class="card OrdemServico">
          <div class="card-header OrdemServico-bgh text-light">
            <h4>Lista de Ordems de Serviço</h4>
            <a href="os_create.php" class="btn button-primary btn-sm float-end">Criar Ordem</a>
          </div> <!-- Fim card header-->
          <div class="card-body  OrdemServico-bgb">
            <table id="painel_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Cliente</th>
                  <th>Endereço</th>
                  <th>Nome do Ativo</th>
                  <th>Patrimônio do Ativo</th>
                  <th>Data de Chegada</th>
                  <th>situação</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = 'SELECT  tos.os_id, tc.nome AS nome_cliente, te.endereco, te.bairro, te.cidade, tos.data_chegada, ta.nome AS nome_ativo, ta.patrimonio, tos.situacao FROM tb_ativo AS ta, tb_endereco AS te, tb_ordem_servico AS tos, tb_cliente AS tc WHERE tos.ativo_id = ta.ativo_id AND te.cliente_id = tos.cliente_id AND tos.cliente_id = tc.cliente_id;';
                $OrdemServicos = mysqli_query($osdatabase, $sql);
                if (mysqli_num_rows($OrdemServicos) > 0) {
                  foreach ($OrdemServicos as $OrdemServico) {

                ?>
                    <tr>
                      <td><?= $OrdemServico['os_id']; ?></td>
                      <td><?= $OrdemServico['nome_cliente']; ?></td>
                      <td><?= $OrdemServico['endereco'] . ", " . $OrdemServico['bairro'] . ", " . $OrdemServico['cidade']; ?></td>
                      <td><?= $OrdemServico['nome_ativo']; ?></td>
                      <td><?= $OrdemServico['patrimonio']; ?></td>
                      <td><?= date('d/m/Y', strtotime($OrdemServico['data_chegada'])); ?></td>
                      <td><?= $OrdemServico['situacao']; ?></td>
                      <td>
                        <a href="os_view.php?os_id=<?= $OrdemServico['os_id']; ?>" class="btn btn-secondary btn-sm"><i class="bi bi-eye"></i> Vizualizar</a>
                        <a href="os_editor.php?os_id=<?= $OrdemServico['os_id']; ?>" class="btn btn-success btn-sm"><i class="bi bi-pencil-square"></i> Editar</a>
                        <a href="os_pdf.php?os_id=<?= $OrdemServico['os_id']; ?>" class="btn btn-primary btn-sm"><i class="bi bi-filetype-pdf"></i> Gerar PDF</a>

                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal_excluir_os">
                          <i class="bi bi-trash"></i> Excluir
                        </button>

                      </td>
                    </tr>
                <?php
                  }
                } else {
                  echo '<h5>Nenhuma Ordem de Serviço encontrada</h5>';
                }
                ?>
              </tbody>
            </table>

          </div><!-- fim do card body-->
        </div><!-- fim do card -->

      </div>

    </div>
  </main>

  <!-- Modal -->
  <div class="modal fade" id="modal_excluir_os" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark rounded">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir Ordem de Serviço</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-dark text-light">
          Tem certeza que deseja excluiir esté ordem de serviço?
        </div>
        <div class="modal-footer bg-dark text-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"> <i class="bi bi-arrow-return-left"></i> Close</button>

          <form action="../src/excluir_ordem.php" method="POST" class="d-inline">
            <input type="hidden" name="delete_os" value="<?= $OrdemServico['os_id']; ?>">
            <button type="submit" class="btn btn-danger btn-sm">
              <i class="bi bi-trash"></i> Excluir
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

<script>
  $(document).ready(function() {
    $('#painel_table').DataTable({
      language: {
        info: 'Exibindo Páginas _PAGE_ De _PAGES_',
        infoEmpty: 'Sem Registros disponíveis',
        infoFiltered: '(Filtrando de _MAX_ registros totais)',
        lengthMenu: 'Mostrar _MENU_ Registros por página',
        zeroRecords: 'Não encontrado - desculpe',

      }
    });
  });
</script>

<script src="../assets/library/bootstrap.bundle.min.js"></script>


</html>