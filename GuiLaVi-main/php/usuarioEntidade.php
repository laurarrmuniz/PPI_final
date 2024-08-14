<?php
class UsuarioEntidade {
    private $cpf;
    private $nome;
    private $sobrenome;
    private $email;

    public function getCpf() {
        return $this->cpf;
    }
    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome= $nome;
    }

    public function getSobrenome() {
        return $this->sobrenome;
    }
    public function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
}
?>