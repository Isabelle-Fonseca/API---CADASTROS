<?php
require('./header.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);

    if ($nome && $endereco) {
        $sql = $pdo->prepare("INSERT INTO pessoa (nome, endereco) VALUES (:nome, :endereco)");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':endereco', $endereco);
        $sql->execute();
    } else {
        $array['error'] = 'Erro: Valores nulos ou inválidos!';
    }
} else {
    $array['error'] = 'Erro: Ação inválida - Método permitido apenas POST';
}

require('./../return.php');
