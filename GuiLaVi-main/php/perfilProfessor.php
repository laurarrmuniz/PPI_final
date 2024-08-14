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
  $sql = "SELECT nome, sobrenome, cpf, email, senha, interesse, descricao, nomeArqFoto
          FROM usuarios
          LEFT JOIN fotoUsuario ON usuarios.id = fotoUsuario.id_usuario
          WHERE usuarios.email = '$email'";

  $stmt = $conn->conexao->query($sql);

  $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

  $nome = $resultado['nome'];
  $sobrenome = $resultado['sobrenome'];
  $cpf = $resultado['cpf'];
  $email = $resultado['email'];
  $senha = $resultado['senha'];
  $interesse = $resultado['interesse'];
  $descricao = $resultado['descricao'];
  $nomeArqFoto = $resultado['nomeArqFoto'];

  if (!$nomeArqFoto) {
    $nomeArqFoto = 'default.jpg';

    //Seleciona o id do usuário de acordo com o email da sessão
    $sql2 = "SELECT id FROM usuarios WHERE email = '$email'";
    $sql2 = $conn->conexao->query($sql2);
    $row = $sql2->fetch();
    $id_usuario = $row['id'];

    //Insere no banco o Default
    $sqlFotoDefault = "INSERT INTO fotoUsuario (id_usuario, nomeArqFoto) VALUES (?, ?)";

    $stmt2 = $conn->conexao->prepare($sqlFotoDefault);
    $stmt2->bindParam(1, $id_usuario);
    $stmt2->bindParam(2, $nomeArqFoto);
    $stmt2->execute();
  }
} catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/bootstrap-4.3.1.min.css">
  <link rel="stylesheet" href="../css/perfil.css">
  <link rel="stylesheet" href="../css/modal.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css'>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../js/bootstrap-4.3.1.bundle.min.js.js"></script>
  <script src="../js/modal.js"></script>
  <title>Perfil Professor</title>
</head>


<body>
  <header id="menu" class="p-3 text-bg-dark">
    <nav class="navbar navbar-light bg-light justify-content-center">
      <a class="navbar-brand" href="#">
        <img src="../img/logo.png" class="d-inline-block align-top" alt="">
      </a>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="login_nav">
      <a class="navbar-brand" href="./area_professor.php" id="home">Home</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link active" href="./criarTurma.php">Criar Turma <span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link active" href="./minhasTurmas.php">Minhas Turmas<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link active" href="./altera_dados.php">Alterar Dados<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link active" href="./perfilProfessor.php">Meus Dados<span class="sr-only">(current)</span></a>
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
    <div id="container">
      <div class="deletaConta btnOpenModal"><a href="#">Deletar Conta</a></div>
      <img src="../img/<?php echo $nomeArqFoto; ?>" class="img-fluid rounded-circles" width="100" height="100" alt="Imagem do Perfil">
      <h1><?php echo $nome . ' ' . $sobrenome; ?></h1>

      <hr>

      <section>
        <p><strong>CPF:</strong> <?php echo $cpf; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Área de Interesse:</strong> <?php echo $interesse; ?></p>
        <p><strong>Descrição:</strong> <?php echo $descricao; ?></p>
      </section>

      <form action="upload_imagem.php" method="post" enctype="multipart/form-data">
        <div>
          <input type="file" accept=".png, .jpg, .jpeg" name="foto">
        </div>
        <div class="botão">
          <button type="submit" class="btn btn-primary" name="submit">Alterar Imagem</button>
        </div>
      </form>

    </div>

  </main>

  <?php

  $sql3 = "SELECT id FROM usuarios WHERE email = '$email'";
  $sql3 = $conn->conexao->query($sql3);
  $row = $sql3->fetch();
  $id_usuario = $row['id'];

  echo <<<HTML
<div id="modalTeste" class="modal"> <!-- utiliza a classe .modal declarada no css -->

<div class="modalContent"> <!-- utiliza a classe .modalContent declarada no css. É responsável pela janela do modal. -->
  <h2>Tem certeza de que deseja Deletar sua conta?</h2>
  <p>Ao clicar no botão sim, sua conta será imediatamente deletada.</p>
  <button class="btn"><a href="deleta_conta.php?id=$id_usuario">Sim</a></button>
  <button class="btn" id="buttonClose">Não</button>
</div>

</div>
    
HTML;
  ?>

  <footer class="footer">
    <div class="container">
      <div class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
          <li class="nav-item"><a href="./area_professor.php" class="nav-link px-2 text-body-secondary">Home</a></li>
          <li class="nav-item"><a href="./criarTurma.php" class="nav-link px-2 text-body-secondary">Criar Turma</a></li>
          <li class="nav-item"><a href="./minhasTurmas.php" class="nav-link px-2 text-body-secondary">Minhas Turmas</a></li>
          <li class="nav-item"><a href="./altera_dados.php" class="nav-link px-2 text-body-secondary">Alterar Dados</a></li>
          <li class="nav-item"><a href="./perfilProfessor.php" class="nav-link px-2 text-body-secondary">Meus Dados</a></li>
          <li class="nav-item"><a href="./itensCadastro.php" class="nav-link px-2 text-body-secondary">Buscar</a></li>
        </ul>
        <p class="text-center text-body-secondary">© 2023 Company, Inc</p>
      </div>
    </div>
  </footer>

</body>

</html>