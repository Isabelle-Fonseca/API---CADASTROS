<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'PUT') {
    parse_str(file_get_contents("php://input"), $put);

    $id = filter_var($put['id'] ?? null, FILTER_VALIDATE_INT);
    $ddi = $put['ddi'] ?? null;
    $ddd = $put['ddd'] ?? null;
    $telefone = $put['telefone'] ?? null;

    if ($id && $ddi && $ddd && $telefone) {
        $sql = $pdo->prepare("UPDATE telefone SET ddi = :ddi, ddd = :ddd, telefone = :telefone WHERE idTelefone = :id");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':ddi', $ddi);
        $sql->bindValue(':ddd', $ddd);
        $sql->bindValue(':telefone', $telefone);
        $sql->execute();

        $array['result'] = [
            "id" => $id,
            "ddi" => $ddi,
            "ddd" => $ddd,
            "telefone" => $telefone
        ];
    } else {
        $array['error'] = 'Erro: Valores nulos ou inválidos!';
    }
} else {
    $array['error'] = 'Erro: Método inválido - Apenas PUT é permitido.';
}

require('./../return.php');
