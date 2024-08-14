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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css'>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/bootstrap-4.3.1.bundle.min.js.js"></script>
    <title>GuiLaViEducation-AreaDoProfessor</title>
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
        <div class="container">

            <h2>Criar Turma</h2>

            <form name="formCriaTurma" id="loginForm" class="row g-2" action=" " method="POST" enctype="multipart/form-data">

                <div class="col-md-12 form-floating">
                    <input type="text" id="nome" name="nome_turma" autocomplete="off" class="form-control" placeholder="Nome Turma"
                        maxlength="100" required>
                    <label for="nome" class="form-label">Nome da turma</label>
                    <div class="alert alert-danger d-none" id="alert-nome"></div>
                </div>

                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição (até 300 caracteres):</label><br>
                    <textarea id="descricao" name="descricao" rows="4" class="form-control" maxlength="300"
                        placeholder="Escreva aqui informações sobre a turma que você está criando."></textarea>
                    <div class="alert alert-danger d-none" id="alert-descricao"></div>
                </div>

                <div>
                <input type="file" accept=".png, .jpg, .jpeg" name="foto[]">
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Criar</button>
                </div>

            </form>

      <?php
      $email = $_SESSION['email'];
      
      if (isset($_POST["nome_turma"]) && isset($_POST["descricao"]) && isset($_FILES["foto"])) {
        require_once "conexao.php";
        require_once "usuarioEntidade.php";
    
        $nome_turma = $_POST["nome_turma"];
        $descricao = $_POST["descricao"];
        $fotos = array();
    
        if (isset($_FILES['foto'])) {
            for ($i = 0; $i < count($_FILES['foto']['name']); $i++) {
                $nomeArqFoto = $_FILES['foto']['name'][$i];
                $nomeArqFoto = strtolower($nomeArqFoto); // Garante que a extensão está em minúsculas
                move_uploaded_file($_FILES['foto']['tmp_name'][$i], '../img/' . $nomeArqFoto);
    
                // Salvando nomes para enviar para o banco
                array_push($fotos, $nomeArqFoto);
            }
        } else {
            echo "Você não realizou o upload de forma satisfatória.";
        }
    
        $conn = new Conexao();
    
        $sql = "INSERT INTO turmas (nome_turma, descricao, id_usuario) VALUES (?, ?, ?)";
        $sql2 = "INSERT INTO foto (id_turma, nomeArqFoto) VALUES (?, ?)";
        $sql3 = "SELECT id FROM usuarios WHERE email = '$email'";

        $sql3 = $conn->conexao->query($sql3);
        $row = $sql3->fetch();
        $id_usuario = $row['id'];
        
        
        $stmt1 = $conn->conexao->prepare($sql);
    
        $stmt1->bindParam(1, $nome_turma);
        $stmt1->bindParam(2, $descricao);
        $stmt1->bindParam(3, $id_usuario);
    
        if ($stmt1->execute()) {
            if ($stmt1->rowCount() > 0) {
               echo "Turma criada com sucesso!<br>";
            } else {
                echo "Falha na primeira inserção<br>";
            }
        }
    
        $id_turma = $conn->conexao->lastInsertId();
    
        foreach ($fotos as $nomeArqFoto) {
            $stmt2 = $conn->conexao->prepare($sql2);
            $stmt2->bindParam(1, $id_turma);
            $stmt2->bindParam(2, $nomeArqFoto);
    
            if ($stmt2->execute()) {
                if ($stmt2->rowCount() > 0) {
                   echo "Imagens associadas à turma com sucesso!<br>";
                } else {
                    echo "Falha na segunda inserção<br>";
                }
            }
        }
    }
      ?>

      </div>
    </main>

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