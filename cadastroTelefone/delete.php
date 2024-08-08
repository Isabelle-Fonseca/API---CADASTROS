<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'DELETE') {
    parse_str(file_get_contents("php://input"), $delete);

    $id = filter_var($delete['id'] ?? null, FILTER_VALIDATE_INT);

    if ($id) {
        
        $sql = $pdo->prepare("DELETE FROM telefone WHERE idPessoa = :id");// exclui o telefone
        $sql->bindValue(':id', $id);
        $sql->execute();

        
        $sql = $pdo->prepare("DELETE FROM pessoa WHERE idPessoa = :id"); // aqui exclui a pessoa
        $sql->bindValue(':id', $id);
        $sql->execute();

        $array['result'] = 'Pessoa e telefones excluídos com sucesso!';
    } else {
        $array['error'] = 'Erro: Id inválido!';
    }
} else {
    $array['error'] = 'Erro: Método inválido - Apenas DELETE é permitido.';
}

require('./../return.php');
