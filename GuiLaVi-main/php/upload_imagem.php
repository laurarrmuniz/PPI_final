<?php
session_start();

$email = $_SESSION['email'];

require "conexao.php";
$conn = new Conexao();

if (!isset($_SESSION['email']))
    header("location: ../login.html");

//Fazer logout
if (isset($_GET['sair'])) {
    unset($_SESSION['email']);
    header("location: ../index.html");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $caminho_imagem = "../img/";
    $imageFileType = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

    // Define um nome único para o arquivo usando timestamp
    $timestamp = time();
    $uploadFile = $caminho_imagem . "perfil_" . $timestamp . "." . $imageFileType;
    $nomeArqFoto =  "perfil_" . $timestamp . "." . $imageFileType;

    //Seleciona o id do usuário de acordo com o email da sessão
    $sql2 = "SELECT id, tipo FROM usuarios WHERE email = '$email'";

    $sql2 = $conn->conexao->query($sql2);
    $row = $sql2->fetch();
    $id_usuario = $row['id'];
    $tipo_usuario = $row['tipo'];


    // Se tudo estiver ok, tentar fazer o upload do arquivo
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $uploadFile)) {

        // Insere o nome da imagem no banco de dados
        $sql = "UPDATE fotoUsuario SET nomeArqFoto = ? WHERE id_usuario = $id_usuario";
        $stmt = $conn->conexao->prepare($sql);
        $stmt->bindParam(1, $nomeArqFoto);
        $stmt->execute();
        if($tipo_usuario === 'aluno'){
            header("Location: perfilAluno.php");
        }else{
            header("Location: perfilProfessor.php");
        }
    } else {
        echo "Desculpe, ocorreu um erro ao fazer upload do seu arquivo.";
    }
}
