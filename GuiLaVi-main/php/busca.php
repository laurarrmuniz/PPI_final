<?php

require "conexao.php";
$conn = new Conexao();

try {
  $sql = "SELECT nome_turma, descricao, nomeArqFoto FROM turmas INNER JOIN foto ON turmas.id = foto.id_turma";
  $stmt = $conn->conexao->prepare($sql);
    $stmt->execute();

  // Armazenar os resultados em arrays
  $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/modal.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/bootstrap-4.3.1.min.css">
  <link rel="stylesheet" href="../css/itensCadastro.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css'>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../js/bootstrap-4.3.1.bundle.min.js.js"></script>
  <script src="../js/script.js"></script>
  <script src="../js/modal.js"></script>
  <title>GuiLaViEducation-Busca</title>
</head>

<body>
  <header id="menu" class="p-3 text-bg-dark">
    <nav class="navbar navbar-light bg-light justify-content-center">
      <a class="navbar-brand" href="#">
        <img src="../img/logo.png" class="d-inline-block align-top" alt="">
      </a>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="../index.html" id="home">Home</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link active" href="../cadastroUsuario.html">Cadastrar<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link active" href="../sobre.html">Sobre <span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link active" href="#">Buscar<span class="sr-only">(current)</span></a>
          <form class="form-inline my-2 my-lg-0 login-botao">
            <img class="login-img" src="../img/icons/unlogged-icon.svg" alt="">
            <a href="../login.html" class="btn btn-outline-success my-2 my-sm-0">Login</a>
          </form>
        </div>
      </div>
    </nav>
  </header>
  <main>

    <div class="container">

      <form class="d-flex" id="form">
        <img class="search-img" src="../img/icons/search.svg" alt="">
        <input class="form-control me-2" type="search" id="searchInput" placeholder="Pesquisar" aria-label="Pesquisar">
        <button class="btn btn-outline-success" id="button" type="submit">Buscar</button>
      </form>

      <div id="container" class="row">

        <?php foreach ($resultados as $resultado) : ?>
          <?php
          $nome_turma = htmlspecialchars($resultado['nome_turma']);
          $descricao = htmlspecialchars($resultado['descricao']);
          $nomeArqFoto = htmlspecialchars($resultado['nomeArqFoto']);
          $caminho_imagem = "../img/$nomeArqFoto";
          ?>

          <div class="coluna col-lg-6">
            <div class="item">
              <img src="<?= $caminho_imagem ?>" width="200" height="200" alt="<?= $nome_turma ?>">
              <div class="alinha_item">
                <h4><?= $nome_turma ?></h4>
                <p><?= $descricao ?></p>
                <button class="btn btn-success btnOpenModal">Participar</button>
              </div>
            </div>
          </div>

        <?php endforeach; ?>

      </div>
    </div>

  </main>

  <div id="modalTeste" class="modal"> <!-- utiliza a classe .modal declarada no css -->

    <div class="modalContent"> <!-- utiliza a classe .modalContent declarada no css. É responsável pela janela do modal. -->
      <h2>Necessário Login</h2>
      <p>É necessário que seja feito login para participar de uma turma. Caso não tenha login, faça o cadastro.</p>
      <button class="btn btn-sucess" id="buttonClose">Ok</button>
    </div>

  </div>

  <footer class="footer">
    <div class="container">
      <div class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
          <li class="nav-item"><a href="../index.html" class="nav-link px-2 text-body-secondary">Home</a></li>
          <li class="nav-item"><a href="../cadastroUsuario.html" class="nav-link px-2 text-body-secondary">Cadastrar</a></li>
          <li class="nav-item"><a href="../sobre.html" class="nav-link px-2 text-body-secondary">Sobre</a></li>
          <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Buscar</a></li>
          <li class="nav-item"><a href="../login.html" class="nav-link px-2 text-body-secondary">Login</a></li>
        </ul>
        <p class="text-center text-body-secondary">© 2023 Company, Inc</p>
      </div>
    </div>
  </footer>

</body>

</html>