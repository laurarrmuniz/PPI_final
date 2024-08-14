<?php

session_start();

$email = $_SESSION['email'];

$id = isset($_SESSION['edit_id']) ? $_SESSION['edit_id'] : null;
unset($_SESSION['edit_id']);

require "conexao.php";
$conn = new Conexao();


    // Recupera dados do formulário
    $nome_turma = $_POST["nome_turma"] ?? "";
    $descricao = $_POST["descricao"] ?? "";
    $fotos = array();

    if (isset($_FILES['foto'])) {
      for ($i = 0; $i < count($_FILES['foto']['name']); $i++) {
          $nomeArqFoto = $_FILES['foto']['name'][$i];
          $nomeArqFoto = strtolower($nomeArqFoto); // Garante que a extensão está em minúsculas
          move_uploaded_file($_FILES['foto']['tmp_name'][$i], '../img/' . $nomeArqFoto);

          // Salvando nomes para enviar para o banco
          array_push($fotos, $nomeArqFoto);
      }
  } else {
      echo "Você não realizou o upload de forma satisfatória.";
  }

    // Atualização no banco de dados
    try {
        $sql = "UPDATE turmas SET nome_turma = ?, descricao = ? WHERE id = ?";
        $stmt = $conn->conexao->prepare($sql);
        $stmt->bindParam(1, $nome_turma);
        $stmt->bindParam(2, $descricao);
        $stmt->bindParam(3, $id);

        $sql2 = "UPDATE foto SET nomeArqFoto = ? WHERE id_turma = ?";
        $stmt2 = $conn->conexao->prepare($sql2);
        $stmt2->bindParam(1, $nomeArqFoto);
        $stmt2->bindParam(2, $id);

        if ($stmt->execute() && $stmt2->execute()) {
            // Redireciona de volta para a página de lista após a edição
            header("Location: minhasTurmas.php");
            exit();
        } else {
            echo "Erro ao editar turma.";
        }
    } catch (PDOException $e) {
        echo "Erro na execução da consulta SQL: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Falha inesperada: " . $e->getMessage();
    }

?>
