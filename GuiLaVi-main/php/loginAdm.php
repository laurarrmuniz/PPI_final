<?php
session_start();

if (isset($_POST["email"]) && isset($_POST["senha"])) {
    require_once "conexao.php";
    require_once "usuarioEntidade.php";

    try {
        $conn = new Conexao();
    } catch (PDOException $e) {
        echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    }

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM administrador WHERE email = :email AND senha = :senha";
    
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();


    if ($stmt->rowCount() == 1) {
        $_SESSION['email'] = $email;
        header("Location: ../php/sistemaPrivado.php");
    } else {
        echo '<script>alert("Usuário não encontrado. Verifique seu email e senha.");</script>';
    }
}
?>
