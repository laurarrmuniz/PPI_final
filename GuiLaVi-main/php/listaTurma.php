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

    $sql = "SELECT id,nome_turma, descricao, id_usuario
    FROM turmas";

    $stmt = $conn->conexao->query($sql);

    if ($stmt->rowCount() > 0) {
        $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $turmas = array();
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
    <title>Listagem de Turmas</title>
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

                            <a class="nav-item nav-link active" href="listaUsuario.php">Usuários <span
                                    class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link active" href="#">Item<span class="sr-only"></span></a>
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
            <h2>Listagem de Turmas</h2>
            <div class="table-responsive">
                <table id="userTable" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome DA Turma</th>
                            <th>Descrição</th>
                            <th>ID Usuário</th>
                            <th>Excluir</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($turmas)): ?>
                            <?php foreach ($turmas as $turma): ?>
                                <tr>
                                    <td>
                                        <?php echo $turma["id"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $turma["nome_turma"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $turma["descricao"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $turma["id_usuario"]; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger"
                                            onclick="excluirUsuario('<?php echo $turma["id"]; ?>')">Excluir</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" data-id="<?php echo $turma["id"]; ?>"
                                            onclick="editarTurma(this)">Editar</button>
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
                        <h5 class="modal-title" id="editarModalLabel">Editar Turma</h5>
                    </div>
                    <div class="modal-body">
                        <label for="editNome">Nome da Turma:</label>
                        <input type="text" id="editNome" class="form-control" required>
                        <label for="editDes">Descrição:</label>
                        <input type="text" id="editDes" class="form-control" required>
                        <label for="editUsu">ID Usuário:</label>
                        <input type="text" id="editUsu" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()"
                            data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" onclick="salvarEdicaoTurma()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cadastrarModal" tabindex="-1" role="dialog" aria-labelledby="cadastrarModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cadastrarModalLabel">Cadastrar Turma</h5>
                    </div>
                    <div class="modal-body">
                        <label for="cadNome">Nome da Turma:</label>
                        <input type="text" id="cadNome" class="form-control" required>
                        <label for="cadDes">Descrição:</label>
                        <input type="text" id="cadDes" class="form-control" required>
                        <label for="cadUsu">ID Usuário:</label>
                        <input type="text" id="cadUsu" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()"
                            data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" onclick="cadastroTurma()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>