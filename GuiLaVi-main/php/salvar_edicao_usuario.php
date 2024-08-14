<?php

require "conexao.php";

$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$interesse = $_POST['interesse'];
$descricao = $_POST['descricao'];
$tipo = $_POST['tipo'];


$conn = new Conexao();

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $sql = "UPDATE usuarios SET nome = :nome, sobrenome = :sobrenome, email = :email, senha = :senha, 
            interesse = :interesse, descricao = :descricao, tipo = :tipo WHERE cpf = :cpf";
    
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':sobrenome', $sobrenome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senhaHash);
    $stmt->bindParam(':interesse', $interesse);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':tipo', $tipo);

    $stmt->execute();

    echo "Usuário atualizado com sucesso!";
} catch (PDOException $e) {
    echo "Ocorreu uma falha: " . $e->getMessage();
} finally {
    $conn->fecharConexao();
}
?>
