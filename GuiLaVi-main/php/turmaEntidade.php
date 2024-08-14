<?php
class TurmaEntidade {
    private $nome_turma;

    public function getNome() {
        return $this->nome_turma;
    }
    public function setNome($nome_turma) {
        $this->nome_turma= $nome_turma;
    }

}
?>