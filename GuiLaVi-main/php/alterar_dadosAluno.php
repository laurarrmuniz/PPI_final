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

  $sql = "SELECT nome, sobrenome, cpf, email, senha, interesse, descricao
  FROM usuarios
  WHERE
  usuarios.email = '$email'";

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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-4.3.1.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css'>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/bootstrap-4.3.1.bundle.min.js.js"></script>
    <title>GuiLaViEducation-Alterar Dados Aluno</title>
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
<div class="container">
        <h3>Alterar Dados</h3>
        <hr>
        <form action="./formAlteraAluno.php" method="post">
            <div class="row g-3">
            <div class="col-md-6 form-floating">
                    <input type="text" id="nome" name="nome" autocomplete="off" class="form-control" placeholder="Nome"
                        maxlength="100">
                    <label for="nome" class="form-label">Nome</label>
                    <div class="alert alert-danger d-none" id="alert-nome"></div>
                </div>

                <div class="col-md-6 form-floating">
                    <input type="text" id="sobrenome" name="sobrenome" class="form-control" placeholder="Sobrenome">
                    <label for="sobrenome" class="form-label">Sobrenome</label>
                    <div class="alert alert-danger d-none" id="alert-sobrenome"></div>
                </div>

                <div class="col-md-6 form-floating">
                    <input type="text" id="cpf" name="cpf" class="form-control" placeholder="cpf" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}">
                    <label for="cpf" class="form-label">CPF</label>
                    <div class="alert alert-danger d-none" id="alert-cpf"></div>
                </div>


                <div class="col-md-6 form-floating">
                    <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha">
                    <label for="senha" class="form-label">Senha</label>
                    <div class="alert alert-danger d-none" id="alert-senha"></div>
                </div>


                <div class="col-md-4">
                    <label for="interesse" class="form-label">Áreas de Interesse:</label>
                    <select id="interesse" name="interesse" class="form-select">
                        <option value="ter">Tecnologia</option>
                        <option value="gep">Gestão de Pessoa</option>
                        <option value="matfin">Matematica Financeira</option>
                        <option value="ppi">Programação Para Internet</option>
                        <option value="outros">Outro</option>

                    </select>
                </div>

                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição (até 300 caracteres):</label><br>
                    <textarea id="descricao" name="descricao" rows="4" class="form-control" maxlength="300"
                        placeholder="Escreva aqui informações adicionais sobre você, se necessário."></textarea>
                    <div class="alert alert-danger d-none" id="alert-descricao"></div>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>

            </div>
        </form>
        <hr>
        <h3>Meus Dados</h3>
        <hr>

      <?php
      while ($row = $stmt->fetch()) {

        $nome = $row['nome'];
        $sobrenome = $row['sobrenome'];
        $cpf= htmlspecialchars($row['cpf']);
        $senha = htmlspecialchars($row['senha']);
        $interesse = htmlspecialchars($row['interesse']);
        $descricao = htmlspecialchars($row['descricao']);
        $email = $_SESSION['email'];

        echo <<<HTML
            <strong>Nome: </strong><p>$nome</p>
            <strong>Sobrenome: </strong><p>$sobrenome</p>
            <strong>CPF: </strong><p>$cpf</p>
            <strong>Email: </strong><p>$email</p>
            <strong>Senha: </strong><p>$senha</p>
            <strong>Descrição: </strong><p>$descricao</p>     
        HTML;
      }
      ?>
    </div>

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
