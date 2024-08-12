<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'GET') {
    $idPessoa = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($idPessoa) {
        $sql = $pdo->prepare("SELECT p.idPessoa, p.nome, t.ddi, t.ddd, t.telefone 
                              FROM pessoa p
                              INNER JOIN telefone t ON p.idPessoa = t.idPessoa
                              WHERE p.idPessoa = :idPessoa");
        $sql->bindValue(':idPessoa', $idPessoa);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array['result'] = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $array['error'] = 'Erro: Pessoa não foi encontrada!';
        }
    } else {
        $array['error'] = 'Erro: ID inválido!';
    }
} else {
    $array['error'] = 'Erro: Método inválido - Apenas GET é permitido.';
}

require('./../return.php');
