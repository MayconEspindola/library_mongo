<?php

namespace app\process_forms;

require_once '../config/database.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once '../config/EnvironmentSettings.php';

function adicionarLivro($dadosLivro, \app\config\EnvironmentSettings $envSettings) {
    $env = $envSettings->obterConfiguracoes();

    try {
        $database = \app\config\Database::insertDocument($env['DATABASE']['collectionA1'], $dadosLivro);
        return $database;
    } catch (\MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
        throw new \Exception("Erro de conexão: Tempo de conexão expirado. Verifique as configurações do servidor MongoDB.");
    } catch (\MongoDB\Driver\Exception\AuthenticationException $e) {
        throw new \Exception("Erro de autenticação: As credenciais fornecidas são inválidas. Verifique o nome de usuário e a senha.");
    } catch (\MongoDB\Driver\Exception\BulkWriteException $e) {
        throw new \Exception("Erro ao inserir documento: " . $e->getMessage());
    } catch (\MongoDB\Driver\Exception\Exception $e) {
        throw new \Exception("Erro ao conectar ao MongoDB: " . $e->getMessage());
    } catch (\Exception $e) {
        throw new \Exception("Erro geral: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $envSettings = new \app\config\EnvironmentSettings();
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $ano = $_POST['ano'];

        // Validar os dados conforme necessário

        $novoLivro = [
            'titulo' => $titulo,
            'autor' => $autor,
            'ano' => $ano,
        ];

        if (adicionarLivro($novoLivro, $envSettings)) {
            header('Location: ../index.html');
            exit();
        } else {
            echo "Erro ao adicionar o livro. Por favor, tente novamente.";
        }
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
} else {
    // Redirecionar para a página do formulário se alguém tentar acessar diretamente
    header('Location: ../index.html');
}
