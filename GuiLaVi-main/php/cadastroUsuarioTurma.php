<?php
session_start();

if (isset($_POST["nome_turma"]) && isset($_POST["descricao"]) && isset($_POST["id_usuario"])) {
    require_once "conexao.php";

    $nome_turma = $_POST["nome_turma"];
    $descricao = $_POST["descricao"];
    $id_usuario = $_POST["id_usuario"];

    $conn = new Conexao();

    $sql = "INSERT INTO turmas (nome_turma, descricao, id_usuario) VALUES (?, ?, ?)";

    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(1, $nome_turma);
    $stmt->bindParam(2, $descricao);
    $stmt->bindParam(3, $id_usuario);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
        exit();
    } else {
        echo json_encode(["success" => false, "error" => "Erro ao tentar efetivar cadastro"]);
        exit();
    }
}
?>
