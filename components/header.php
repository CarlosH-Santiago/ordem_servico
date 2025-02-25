<head>
  <link rel="stylesheet" href="../styles/header.css" />
</head>
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img
        src="../assets/image/cvmulti 1.png"
        alt="Logo"
        width="60"
        height="24"
        class="d-inline-block align-text-top" />
      <span>
        MULTI VARIEDADES
      </span>
    </a>
    <button
      class="navbar-toggler text-bg-dark"
      type="button"
      data-bs-toggle="offcanvas"
      data-bs-target="#offcanvasNavbar"
      aria-controls="offcanvasNavbar"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div
      class="offcanvas offcanvas-end"
      tabindex="-1"
      id="offcanvasNavbar"
      aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header bg-primary">
        <h5 class="offcanvas-title text-light" id="offcanvasNavbarLabel"><img
            src="../assets/image/cvmulti 1.png"
            alt="Logo"
            width="60"
            height="24"
            class="d-inline-block align-text-top" />
          <span>
            MULTI VARIEDADES
          </span>
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="offcanvas"
          aria-label="Close"></button>
      </div>
      <div class="offcanvas-body bg-dark">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">Painel</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Criar Ordem</a>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
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
        <button type="button" class="btn btn-outline-danger my-2" data-bs-toggle="modal" data-bs-target="#modal_logout">
          Sair
        </button>
      </div>
    </div>
  </div>
  <!-- Button trigger modal -->

</nav>

<!-- Modal -->
<div class="modal fade" id="modal_logout" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog bg-dark rounded">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h1 class="modal-title fs-5" id="ModalLabel">Logout de conta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body  bg-dark text-light">
      Você tem certeza que deseja efetuar o logout da sua conta?
      </div>
      <div class="modal-footer bg-dark text-light">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a href="../src/function_logout.php" class="btn btn-outline-danger my-2">Sair</a>      
      </div>
    </div>
  </div>
</div>