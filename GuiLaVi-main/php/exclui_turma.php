<?php
require_once "conexao.php";

try {
    $conn = new Conexao();
} catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    exit;
}


if (isset($_GET["id"])) {
    $id = $_GET["id"];

    try {
        $sql = "DELETE FROM turmas WHERE id = ?";
        $stmt = $conn->conexao->prepare($sql);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            // Redirecione de volta para a página de lista após a exclusão
            header("Location: minhasTurmas.php");
        } else {
            echo "Erro ao excluir o usuário.";
        }
    } catch (PDOException $e) {
        echo "Erro na execução da consulta SQL: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Falha inesperada: " . $e->getMessage();
    }
} else {
    echo "O parâmetro de usuário não foi fornecido.";
}
?>