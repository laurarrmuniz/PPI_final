<?php
session_start();

if (!isset($_SESSION['email']))
    header("location: ../login.html");

//Fazer logout
if (isset($_GET['sair'])) {
    unset($_SESSION['email']);
    header("location: ../index.html");
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-4.3.1.min.css">
    <link rel="stylesheet" href="../css/area_usuario.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css'>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/bootstrap-4.3.1.bundle.min.js.js"></script>
    <title>GuiLaViEducation-AreadoAluno</title>
</head>


<body>
    <header id="menu" class="p-3 text-bg-dark">
        <nav class="navbar navbar-light bg-light justify-content-center">
          <a class="navbar-brand" href="#">
            <img src="../img/logo.png" class="d-inline-block align-top"
              alt="">
          </a>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="login_nav">
          <a class="navbar-brand" href="./area_aluno.php" id="home">Home</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-item nav-link active" href="./perfilAluno.php">Meus Dados <span class="sr-only">(current)</span></a>
              <a class="nav-item nav-link active" href="./alterar_dadosAluno.php">Alterar Dados<span class="sr-only">(current)</span></a> 
              <a class="nav-item nav-link active" href="./itensCadastroAluno.php">Buscar Turma<span class="sr-only">(current)</span></a> 
              <form class="form-inline my-2 my-lg-0 login-botao" method="GET" action="">
                <img class="login-img" src="../img/icons/unlogged-icon.svg" alt="">
                <a href="area_aluno.php?sair=true" class="btn btn-outline-danger my-2 my-sm-0">Sair</a>
              </form> 
            </div>
          </div>
        </nav>
      </header>
      <main>
        <div class=container2>
            <h2>Seja bem-vindo(a) a Área do Aluno!</h2>
            <p>Escolha uma das opções abaixo para começar:</p>
            <div>
                <a href="./perfilAluno.php" class="opcoes">Meus Dados</a>
                <a href="./alterar_dadosAluno.php" class="opcoes">Alterar Dados</a>
                <a href="./itensCadastroAluno.php" class="opcoes">Buscar Turma</a>
            </div>
        </div>
    </main>
    <footer class="footer">
        <div class="container">
            <div class="py-3 my-4">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item"><a href="./area_aluno.php" class="nav-link px-2 text-body-secondary">Home</a></li>
                    <li class="nav-item"><a href="./perfilAluno.php" class="nav-link px-2 text-body-secondary">Perfil</a></li>
                    <li class="nav-item"><a href="./alterar_dados.php" class="nav-link px-2 text-body-secondary">Alterar Dados</a></li>
                    <li class="nav-item"><a href="./itensCadastroAluno.php" class="nav-link px-2 text-body-secondary">Buscar</a></li>
                </ul>
                <p class="text-center text-body-secondary">© 2023 Company, Inc</p>
            </div>
        </div>
    </footer>

</body>

</html>