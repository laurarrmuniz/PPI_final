<?php

require "conexao.php";

$nome_turma = $_POST['nome_turma'];
$descricao = $_POST['descricao'];
$id_usuario = $_POST['id_usuario'];


$conn = new Conexao();

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $sql = "UPDATE turmas SET nome_turma = :nome_turma, descricao = :descricao WHERE id_usuario = :id_usuario";
    
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(':nome_turma', $nome_turma);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':id_usuario', $id_usuario);

    $stmt->execute();

    echo "Turma atualizada com sucesso!";
} catch (PDOException $e) {
    echo "Ocorreu uma falha: " . $e->getMessage();
} finally {
    $conn->fecharConexao();
}
?>
