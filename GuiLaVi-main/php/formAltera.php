<?php

session_start();

$email = $_SESSION['email'];

require "conexao.php";
$conn = new Conexao();

$nome = $_POST["nome"] ?? "";
$sobrenome = $_POST["sobrenome"] ?? "";
$cpf = $_POST["cpf"] ?? "";
$interesse= $_POST["interesse"] ?? "";
$senha = $_POST["senha"] ?? "";
$descricao = $_POST["descricao"] ?? "";

$hashsenha = password_hash($senha, PASSWORD_DEFAULT);


  $sql = <<<SQL
  UPDATE usuarios 
  SET nome = ?,
  sobrenome = ?,
  cpf = ?,
  senha = ?,
  interesse = ?,
  descricao = ?
  WHERE email = '$email'
  SQL;

  $stmt = $conn->conexao->prepare($sql);
  $stmt->execute([
    $nome, $sobrenome, $cpf, $hashsenha, $interesse, $descricao
  ]);

  header("location: altera_dados.php");
  exit();


?>