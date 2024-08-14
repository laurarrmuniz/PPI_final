<?php
session_start();

$email = $_SESSION['email'];

require "conexao.php";
$conn = new Conexao();

if (!isset($_SESSION['email']))
    header("location: ../login.html");

//Fazer logout
if (isset($_GET['sair'])) {
    unset($_SESSION['email']);
    header("location: ../index.html");
}

try {

  $sql = "SELECT turmas.id, turmas.nome_turma, turmas.descricao, foto.nomeArqFoto
  FROM turmas, foto, usuarios
  WHERE
  usuarios.email = '$email'
  AND usuarios.id = turmas.id_usuario
  AND turmas.id = foto.id_turma";

  $stmt = $conn->conexao->query($sql);
} 
catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel='stylesheet' href='../css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css'>
    <link rel="stylesheet" href="../css/bootstrap-4.3.1.min.css">
    <script src="../js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="../js/bootstrap-4.3.1.bundle.min.js.js"></script>
    <title>GuiLaViEducation-AreaDoProfessor</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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
          <a class="navbar-brand" href="./area_professor.php" id="home">Home</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-item nav-link active" href="criarTurma.php">Criar Turma<span class="sr-only">(current)</span></a>
              <a class="nav-item nav-link active" href="minhasTurmas.php">Minhas Turmas<span class="sr-only">(current)</span></a>
              <a class="nav-item nav-link active" href="./altera_dados.php">Alterar Dados<span class="sr-only">(current)</span></a> 
              <a class="nav-item nav-link active" href="./perfilProfessor.php">Perfil<span class="sr-only">(current)</span></a>
              <a class="nav-item nav-link active" href="./itensCadastro.php">Buscar<span class="sr-only">(current)</span></a>
              <form class="form-inline my-2 my-lg-0 login-botao" method="GET" action="">
                <img class="login-img" src="../img/icons/unlogged-icon.svg" alt="">
                <a href="area_aluno.php?sair=true" class="btn btn-outline-danger my-2 my-sm-0">Sair</a>
              </form> 
            </div>
          </div>
        </nav>
</header>

<main>
    <div class="container">
        <h3>Minhas Turmas</h3>
        <table class="table table-striped table-hover">
      <tr>
        <th></th>
        <th>Foto</th>
        <th>Nome Turma</th>
        <th>Descrição</th>
        <th></th>
      </tr>

      <?php
      while ($row = $stmt->fetch()) {

        $id = $row['id'];
        $nome = htmlspecialchars($row['nome_turma']);
        $descricao = htmlspecialchars($row['descricao']);
        $nomeArqFoto = htmlspecialchars($row['nomeArqFoto']);

        echo <<<HTML
          <tr>
          <td>
              <a href="exclui_turma.php?id=$id">
                <img src="../img/icons/delete.svg" width="15" height="15">
              </a>
            </td> 
            <td>$nomeArqFoto</td>
            <td>$nome</td>
            <td>$descricao</td> 
            <td>
              <a href="edita_turma.php?id=$id">
                <img src="../img/icons/editar.svg" width="15" height="15">
              </a>
            </td>   
          </tr>    
        HTML;
      }
      ?>

    </table>
  </div>
        </main>
        <footer class="footer">
        <div class="container">
            <div class="py-3 my-4">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
                    <li class="nav-item"><a href="./criarTurma.php" class="nav-link px-2 text-body-secondary">Criar Turma</a></li>
                    <li class="nav-item"><a href="./minhasTurmas.php" class="nav-link px-2 text-body-secondary">Minhas Turmas</a></li>
                    <li class="nav-item"><a href="./altera_dados.php" class="nav-link px-2 text-body-secondary">Alterar Dados</a></li>
                    <li class="nav-item"><a href="./perfilProfessor.php" class="nav-link px-2 text-body-secondary">Perfil</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Sair</a></li>
                </ul>
                <p class="text-center text-body-secondary">© 2023 Company, Inc</p>
            </div>
        </div>
    </footer>
    
</body>
</html>