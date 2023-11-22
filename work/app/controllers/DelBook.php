<?php

namespace app\process_forms;

require_once '../config/database.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once '../config/EnvironmentSettings.php';

function excluirLivro($tituloLivro, \app\config\EnvironmentSettings $envSettings) {
    $env = $envSettings->obterConfiguracoes();

    $filter = ['titulo' => $tituloLivro];

    try {
        return \app\config\Database::deleteDocument($env['DATABASE']['collectionA1'], $filter);
    } catch (\Exception $e) {
        throw new \Exception("Erro ao excluir o livro: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $envSettings = new \app\config\EnvironmentSettings();
        $tituloLivro = $_POST['titulo'];

        // Validar o título do livro conforme necessário

        if (excluirLivro($tituloLivro, $envSettings)) {
            header('Location: ../index.html');
            exit();
        } else {
            echo "Erro ao excluir o livro. Por favor, tente novamente.";
        }
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
} else {
    // Redirecionar para a página do formulário se alguém tentar acessar diretamente
    header('Location: ../index.html');
}
?>