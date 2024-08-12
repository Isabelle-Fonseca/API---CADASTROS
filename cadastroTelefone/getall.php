<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'GET') {
    $sql = $pdo->query("SELECT p.idPessoa, p.nome, t.ddi, t.ddd, t.telefone 
                        FROM pessoa p
                        INNER JOIN telefone t ON p.idPessoa = t.idPessoa");

    if ($sql->rowCount() > 0) {
        $array['result'] = $sql->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $array['error'] = 'Erro: Nenhuma pessoa com telefone foi encontrado!';
    }
} else {
    $array['error'] = 'Erro: Método inválido - Apenas GET é permitido.';
}

require('./../return.php');

