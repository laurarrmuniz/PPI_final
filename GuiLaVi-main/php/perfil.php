<?php
session_start();
require "conexao.php";

$conn = new Conexao();

if (!isset($_SESSION['email'])) {
    header("location: ../adm/loginAdm.html");
    exit;
}

if (isset($_GET['sair'])) {
    unset($_SESSION['email']);
    header("location: ../adm/loginAdm.html");
}

$emailUsuarioLogado = $_SESSION['email'];


try {

    $sql = "SELECT nome, sobrenome, cpf, senha, email FROM administrador WHERE email = :email";
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(':email', $emailUsuarioLogado, PDO::PARAM_STR);
    $stmt->execute();


    if ($stmt !== false) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $nome = $usuario['nome'];
        $sobrenome = $usuario['sobrenome'];
        $cpf = $usuario['cpf'];
        $email = $usuario['email'];
        $senha = $usuario['senha'];
    } else {
        echo 'Erro na execução da consulta: ' . $conn->conexao->error;
        exit;
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
    <title>Perfil</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha384-Qg00WFl9r0Xr6rUqNLv1ffTSSKEFFCDCKVyHZ+sVt8KuvG99nWw5RNvbhuKgif9z"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/itens.js"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="sistemaPrivado.php">Sistema Privado</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-item nav-link active" href="#">Perfil<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">

                            <a class="nav-item nav-link active" href="listaUsuario.php">Usuários <span
                                    class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link active" href="listaTurma.php">Item<span
                                    class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a href="perfil.php?sair=true" class="btn btn-outline-danger my-2 my-sm-0">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Edição do Perfil</h2>
            <form name="formCadastro" id="loginForm" class="row g-2">
                <div class="col-md-6 form-floating">
                    <input type="text" id="editNome" name="nome" autocomplete="off" class="form-control" placeholder="Nome"
                        maxlength="100" required value="<?php echo $nome; ?>">
                    <label for="editNome" class="form-label">Nome</label>
                    <div class="alert alert-danger d-none" id="alert-nome"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" id="editSobrenome" name="sobrenome" class="form-control" placeholder="Sobrenome"
                        maxlength="100" required value="<?php echo $sobrenome; ?>">
                    <label for="editSobrenome" class="form-label">Sobrenome</label>
                    <div class="alert alert-danger d-none" id="alert-sobrenome"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" id="editCpf" name="cpf" class="form-control" placeholder="CPF" maxlength="100"
                        required value="<?php echo $cpf; ?>">
                    <label for="editCpf" class="form-label">CPF</label>
                    <div class="alert alert-danger d-none" id="alert-cpf"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" id="email" name="editEmail" autocomplete="off" class="form-control"
                        placeholder="Email" maxlength="100" value="<?php echo $email; ?>" readonly>
                    <label for="editEmail" class="form-label">Email</label>
                    <div class="alert alert-danger d-none" id="alert-email"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="password" id="editSenha" name="senha" class="form-control" placeholder="Senha"
                        maxlength="100" required value="<?php echo $senha; ?>">
                    <label for="editSenha" class="form-label">Senha</label>
                    <div class="alert alert-danger d-none" id="alert-senha"></div>
                </div>
            </form>
            <form>
                <button type="submit" class="btn btn-primary" onclick="salvarEdicaoAdm()">Salvar</button>
                <button type="button" class="btn btn-danger" onclick="excluirUsuario(1)">Excluir Conta</button>
            </form>
        </div>
    </main>
</body>

</html>