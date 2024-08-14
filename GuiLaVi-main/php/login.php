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

    $sql = "SELECT senha, tipo FROM usuarios WHERE email = ?";
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $senhaHashBD = $row['senha'];
        $tipo = $row['tipo'];

        if (password_verify($senha, $senhaHashBD) && $tipo === "professor") {

            $_SESSION["login"] = "1";
            $_SESSION["email"] = $email;
            header("Location: area_professor.php");
        } else 
        if(password_verify($senha, $senhaHashBD) && $tipo === "aluno"){
            $_SESSION["login"] = "1";
            $_SESSION["email"] = $email;
            header("Location: area_aluno.php");
        }else {
            echo "Senha incorreta";
        }
    } else {
        echo "Usuário não encontrado";
    }
}
?>