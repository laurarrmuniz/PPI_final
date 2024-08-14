<?php

require "conexao.php";

$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$senha = $_POST['senha'];


$conn = new Conexao();

try {
    $sql = "UPDATE administrador SET nome = :nome, sobrenome = :sobrenome, email = :email, senha = :senha 
    WHERE cpf = :cpf";
    
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':sobrenome', $sobrenome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();

    echo "ADM atualizado com sucesso!";
} catch (PDOException $e) {
    echo "Ocorreu uma falha: " . $e->getMessage();
} finally {
    $conn->fecharConexao();
}
?>
