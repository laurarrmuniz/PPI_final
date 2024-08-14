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

function getTotalUsuarios()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM usuarios";
    $stmt = $conn->conexao->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

$query = "SELECT nome_turma, COUNT(id_usuario) as total_usuarios FROM turmas GROUP BY nome_turma";
$result = $conn->conexao->query($query);

$data = array();
$data[] = ['Turma', 'Número de Usuários'];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = [$row['nome_turma'], (int) $row['total_usuarios']];
}
//echo json_encode($data);

$totalUsuarios = getTotalUsuarios();
$conn->fecharConexao();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/sistema.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha384-Qg00WFl9r0Xr6rUqNLv1ffTSSKEFFCDCKVyHZ+sVt8KuvG99nWw5RNvbhuKgif9z"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/itens.js"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Sistema Privado</a>
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
        <div class="container">
            <div class="tituloAdm">
                <h2>Usuários Cadastrados</h2>
            </div>
            <div class="card">
                <p>Total:
                    <?php echo $totalUsuarios; ?>
                </p>
            </div>
            <div class="tituloAdm">
                <h2>Número de Usuários por Turmas</h2>
            </div>
            <div id="chart_div"></div>
        </div>
    </main>
    <script>
        function drawChart() {
            var jsonData = <?php echo json_encode($data); ?>;
            var data = google.visualization.arrayToDataTable(jsonData);

            var options = {
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);
    </script>
</body>

</html>