<?php
session_start();

$email = $_SESSION['email'];

require "conexao.php";
$conn = new Conexao();

if (!isset($_SESSION['email'])) {
    header("location: ../login.html");
}

// Fazer logout
if (isset($_GET['sair'])) {
    unset($_SESSION['email']);
    header("location: ../index.html");
}

try {
    $sql = "SELECT nome_turma, descricao, nomeArqFoto FROM turmas INNER JOIN foto ON turmas.id = foto.id_turma";
    $stmt = $conn->conexao->query($sql);

    // Armazenar os resultados em arrays
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/modal.css">
    <link rel="stylesheet" href="../css/itensCadastro.css">
    <link rel='stylesheet' href='../css/bootstrap.min.css'>
    <link rel="stylesheet" href="../css/bootstrap-4.3.1.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css'>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
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
            <h2>Olá! Você está participando da turma!</h2>
            <p>Sua requisição de participação da turma foi atendida.</p>
            <button class="btn btn-sucess" id="buttonClose">Ok</button>
        </div>

    </div>

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