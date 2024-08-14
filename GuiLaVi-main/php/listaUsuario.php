<?php
require "conexao.php";

session_start();

$conn = new Conexao();

if (!isset($_SESSION['email'])) {
    header("location: ../adm/loginAdm.html");
    exit;
}

if (isset($_GET['sair'])) {
    unset($_SESSION['email']);
    header("location: ../adm/loginAdm.html");
}

try {

    $sql = "SELECT id,nome, sobrenome, cpf, email, senha, interesse, descricao, tipo
    FROM usuarios";

    $stmt = $conn->conexao->query($sql);

    if ($stmt->rowCount() > 0) {
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $usuarios = array();
        echo "Nenhum usuário encontrado.";
    }
} catch (PDOException $e) {
    exit('Ocorreu uma falha: ' . $e->getMessage());
} finally {

    $conn->fecharConexao();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Usuários</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="../js/adm.js"></script>
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
                            <a class="nav-item nav-link active" href="perfil.php">Perfil<span
                                    class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link active" href="#">Usuários <span
                                    class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link active" href="listaTurma.php">Item<span class="sr-only"></span></a>
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
        <div class="container mt-4">
            <h2>Listagem de Usuários</h2>
            <div class="table-responsive">
                <table id="userTable" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Excluir</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuarios)): ?>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td>
                                        <?php echo $usuario["id"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $usuario["nome"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $usuario["email"]; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger"
                                            onclick="excluirUsuario('<?php echo $usuario["cpf"]; ?>')">Excluir</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" data-id="<?php echo $usuario["id"]; ?>"
                                            onclick="editarUsuario(this)">Editar</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <a href="#" class="btn btn-info" onclick="abrirModalCadastro()">Cadastrar</a>
        </div>
        <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">Editar Usuário</h5>
                    </div>
                    <div class="modal-body">
                        <label for="editNome">Nome:</label>
                        <input type="text" id="editNome" class="form-control" required>
                        <label for="editSobrenome">Sobrenome:</label>
                        <input type="text" id="editSobrenome" class="form-control" required>
                        <label for="editCpf">CPF:</label>
                        <input type="text" id="editCpf" class="form-control" required>
                        <label for="editEmail">Email:</label>
                        <input type="text" id="editEmail" class="form-control" required>
                        <label for="editSenha">Senha:</label>
                        <input type="password" id="editSenha" class="form-control" required>
                        <label for="editInteresse">Interesse:</label>
                        <input type="text" id="editInteresse" class="form-control" required>
                        <label for="editDesc">Descrição:</label>
                        <input type="text" id="editDesc" class="form-control" required>
                        <label for="editTipo">Tipo:</label>
                        <input type="text" id="editTipo" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" onclick="salvarEdicaoUsuario()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cadastrarModal" tabindex="-1" role="dialog" aria-labelledby="cadastrarModalLabel"
            aria-hidden="true">
            <!-- Conteúdo do modal de cadastro aqui -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cadastrarModalLabel">Cadastrar Usuário</h5>
                    </div>
                    <div class="modal-body">
                        <label for="cadNome">Nome:</label>
                        <input type="text" id="cadNome" class="form-control" required>
                        <label for="cadSobrenome">Sobrenome:</label>
                        <input type="text" id="cadSobrenome" class="form-control" required>
                        <label for="cadCpf">CPF:</label>
                        <input type="text" id="cadCpf" class="form-control" required>
                        <label for="cadEmail">Email:</label>
                        <input type="text" id="cadEmail" class="form-control" required>
                        <label for="cadSenha">Senha:</label>
                        <input type="password" id="cadSenha" class="form-control" required>
                        <label for="cadInteresse">Interesse:</label>
                        <input type="text" id="cadInteresse" class="form-control" required>
                        <label for="cadDesc">Descrição:</label>
                        <input type="text" id="cadDesc" class="form-control" required>
                        <label for="cadTipo">Tipo:</label>
                        <input type="text" id="cadTipo" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()"
                            data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" onclick="cadastroUsuario()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>