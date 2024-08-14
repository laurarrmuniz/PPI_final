<?php
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $conn = new Conexao();
    $userId = $_POST["id"];

    try {
        $sql = "SELECT nome_turma,descricao,id_usuario FROM turmas WHERE id = :id";
        $stmt = $conn->conexao->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $turma = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($turma) {
            echo json_encode(array('success' => true, 'turma' => $turma));
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
