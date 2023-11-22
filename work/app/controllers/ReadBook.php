<?php

namespace app\process_forms;

require_once '../config/database.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once '../config/EnvironmentSettings.php';

function buscarLivro($termo, $tipoPesquisa, \app\config\EnvironmentSettings $envSettings) {
    $env = $envSettings->obterConfiguracoes();

    switch ($tipoPesquisa) {
        case 'titulo':
            $filter = ['titulo' => $termo];
            break;
        case 'autor':
            $filter = ['autor' => $termo];
            break;
        case 'ano':
            $filter = ['ano' => (int)$termo];
            break;
        default:
            throw new \Exception("Tipo de pesquisa inválido.");
    }

    try {
        $livro = \app\config\Database::getResultFromQuery($env['DATABASE']['collectionA1'], $filter);

        // Verifica se encontrou o livro
        if (!empty($livro)) {
            return $livro;
        } else {
            throw new \Exception("Livro não encontrado.");
        }
    } catch (\Exception $e) {
        throw new \Exception("Erro ao buscar o livro: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $envSettings = new \app\config\EnvironmentSettings();
        $termo = $_POST['termo'];
        $tipoPesquisa = $_POST['tipoPesquisa'];

        // Validar os dados conforme necessário

        $livroEncontrado = buscarLivro($termo, $tipoPesquisa, $envSettings);
        
        // Exibir as informações do livro encontrado (pode ser redirecionado para uma página específica)
        echo "<h3>Informações do Livro:</h3>";
        echo "<p>Título: " . $livroEncontrado['titulo'] . "</p>";
        echo "<p>Autor: " . $livroEncontrado['autor'] . "</p>";
        echo "<p>Ano de Publicação: " . $livroEncontrado['ano'] . "</p>";

    } catch (\Exception $e) {
        echo $e->getMessage();
    }
} else {
    // Redirecionar para a página do formulário se alguém tentar acessar diretamente
    header('Location: ../index.html');
}
?>