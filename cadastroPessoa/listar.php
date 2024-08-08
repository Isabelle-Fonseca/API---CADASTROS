<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'GET') {
    $sql = $pdo->query("SELECT idPessoa, nome, endereco FROM pessoa");//utilizei o query pois não vai ser necessario passar parametros

    if ($sql->rowCount() > 0) {
        $array['result'] = $sql->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $array['error'] = 'Erro: Nenhuma pessoa foi encontrada!';
    }
} else {
    $array['error'] = 'Erro: Método inválido - Apenas GET é permitido.';
}

require('../return.php');
