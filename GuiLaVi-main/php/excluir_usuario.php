<?php
require "conexao.php";;

$cpf = $_POST['cpf'];

$conn = new Conexao();

try {
    $sql = "DELETE FROM usuarios WHERE cpf = :cpf";
    
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Ocorreu uma falha: ' . $e->getMessage()]);
} finally {
    
    $conn->fecharConexao();
}
?>
