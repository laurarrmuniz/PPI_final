<?php
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $conn = new Conexao();
    $userId = $_POST["id"];

    try {
        $sql = "SELECT nome, sobrenome, cpf, email, senha, interesse, descricao FROM usuarios WHERE id = :id";
        $stmt = $conn->conexao->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            echo json_encode(array('success' => true, 'usuario' => $usuario));
        } else {
            echo json_encode(array('success' => false));
        }
    } catch (PDOException $e) {
        echo json_encode(array('success' => false));
    } finally {
        $conn->fecharConexao();
    }
} else {
    echo json_encode(array('success' => false));
}
?>
