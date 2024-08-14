<?php
    session_start();
    if(isset($_POST["cpf"]) && isset($_POST["senha"]) && isset($_POST["nome"]) && isset($_POST["sobrenome"])
    && isset($_POST["email"]) && isset($_POST["interesse"]) && isset($_POST["tipo"]) && isset($_POST["descricao"])) {
        require_once "conexao.php";
        require_once "usuarioEntidade.php";
        
        $cpf = $_POST["cpf"];
        $senha = $_POST["senha"];
        $nome = $_POST["nome"];
        $sobrenome = $_POST["sobrenome"];
        $email = $_POST["email"];
        $interesse = $_POST["interesse"];
        $tipo = $_POST["tipo"];
        $descricao = $_POST["descricao"];
        

        $conn = new Conexao();

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, sobrenome, cpf, email, senha, interesse, tipo, descricao) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ";
        
        $stmt = $conn->conexao->prepare($sql);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $sobrenome);
        $stmt->bindParam(3, $cpf);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $senhaHash);
        $stmt->bindParam(6, $interesse);
        $stmt->bindParam(7, $tipo);
        $stmt->bindParam(8, $descricao);
        if ($stmt->execute()) {
             if ($stmt->rowCount() > 0) {
                header("location: ../cadastroSucesso.html");
                exit();
        } else {
            echo "Erro ao tentar efetivar cadastro";
        }
        }
    }
?>