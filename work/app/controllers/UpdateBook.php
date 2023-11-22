<?php

namespace app\process_forms;

require_once '../config/database.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once '../config/EnvironmentSettings.php';

function atualizarLivro($titulo, $novoTitulo, $novoAutor, $novoAno, \app\config\EnvironmentSettings $envSettings) {
    $env = $envSettings->obterConfiguracoes();

    $filter = ['titulo' => $titulo];
    $update = [
        '$set' => [
            'titulo' => $novoTitulo,
            'autor' => $novoAutor,
            'ano' => $novoAno,
        ],
    ];

    try {
        return \app\config\Database::updateDocument($env['DATABASE']['collectionA1'], $filter, $update);
    } catch (\Exception $e) {
        throw new \Exception("Erro ao atualizar o livro: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $envSettings = new \app\config\EnvironmentSettings();
        $titulo = $_POST['titulo'];
        $novoTitulo = $_POST['novoTitulo'];
        $novoAutor = $_POST['novoAutor'];
        $novoAno = $_POST['novoAno'];

        // Validar os dados conforme necessário

        if (atualizarLivro($titulo, $novoTitulo, $novoAutor, $novoAno, $envSettings)) {
            header('Location: ../index.html');
            exit();
        } else {
            echo "Erro ao atualizar o livro. Por favor, tente novamente.";
        }
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
} else {
    // Redirecionar para a página do formulário se alguém tentar acessar diretamente
    header('Location: ../index.html');
}
?>
