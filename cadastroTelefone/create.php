<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'POST') {
    $idPessoa = filter_input(INPUT_POST, 'idPessoa', FILTER_VALIDATE_INT);
    $ddi = filter_input(INPUT_POST, 'ddi');
    $ddd = filter_input(INPUT_POST, 'ddd');
    $telefone = filter_input(INPUT_POST, 'telefone');

    if ($idPessoa && $ddi && $ddd && $telefone) {
        $sql = $pdo->prepare("INSERT INTO telefone (idPessoa, ddi, ddd, telefone) VALUES (:idPessoa, :ddi, :ddd, :telefone)");
        $sql->bindValue(':idPessoa', $idPessoa);
        $sql->bindValue(':ddi', $ddi);
        $sql->bindValue(':ddd', $ddd);
        $sql->bindValue(':telefone', $telefone);
        $sql->execute();

        $array['result'] = [
            'idPessoa' => $idPessoa,
            'ddi' => $ddi,
            'ddd' => $ddd,
            'telefone' => $telefone
        ];

    } else {
        $array['error'] = 'Erro: Valores nulos ou inválidos!';
    }
} else {
    $array['error'] = 'Erro: Método inválido - Apenas POST é permitido.';
}

require('./../return.php');
