<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'PUT') {
    parse_str(file_get_contents("php://input"), $put);

    $idpessoa = filter_var($put['idpessoa'] ?? null, FILTER_VALIDATE_INT);
    $nome = filter_var($put['nome'] ?? null, FILTER_SANITIZE_SPECIAL_CHARS);
    $endereco = filter_var($put['endereco'] ?? null, FILTER_SANITIZE_SPECIAL_CHARS);


    if ($idpessoa) {
        $sql = $pdo->prepare("SELECT * FROM pessoa WHERE idpessoa = :idpessoa");
        $sql->bindValue(":idpessoa", $idpessoa);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            if ($nome && $endereco) {
                $sql = $pdo->prepare("UPDATE pessoa SET nome = :nome, endereco = :endereco WHERE idpessoa = :idpessoa");
                $sql->bindValue(':idpessoa', $idpessoa);
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':endereco', $endereco);
                $sql->execute();
                
                $array = [
                    "idpessoa" => $idpessoa,
                    "nome" => $nome,
                    "endereco" => $endereco
                ];
                $array['result'] = 'Item atualizado com sucesso!';
            } elseif ($nome) {
                $sql = $pdo->prepare("UPDATE pessoa SET nome = :nome WHERE idpessoa = :idpessoa");
                $sql->bindValue(':idpessoa', $idpessoa);
                $sql->bindValue(':nome', $nome);
                $sql->execute();
                
                $array = [
                    "idpessoa" => $idpessoa,
                    "nome" => $nome
                ];
                $array['result'] = 'Nome atualizado com sucesso!';
            } elseif ($endereco) {
                $sql = $pdo->prepare("UPDATE pessoa SET endereco = :endereco WHERE idpessoa = :idpessoa");
                $sql->bindValue(':idpessoa', $idpessoa);
                $sql->bindValue(':endereco', $endereco);
                $sql->execute();
                
                $array = [
                    "idpessoa" => $idpessoa,
                    "endereco" => $endereco
                ];
                $array['result'] = 'Endereço atualizado com sucesso!';
            } else {
                $array['error'] = 'Erro: Nenhum parâmetro válido para atualizar!';
            }
        } else {
            $array['error'] = 'Erro: ID inexistente!';
        }
    } else {
        $array['error'] = 'Erro: ID inválido!';
    }
} else {
    $array['error'] = 'Erro: Método inválido - Apenas PUT é permitido.';
}

require('./../return.php');

?>



