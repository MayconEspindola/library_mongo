<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $ano = $_POST['ano'];

        // Validar os dados conforme necessário

        $novoLivro = [
            'titulo' => $titulo,
            'autor' => $autor,
            'ano' => $ano,
        ];

        $database = \app\config\Database::insertDocument('livros', $novoLivro);

        if ($database) {
            echo "Livro adicionado com sucesso!";
        } else {
            echo "Erro ao adicionar o livro. Por favor, tente novamente.";
        }
    } catch (\MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
        echo "Erro de conexão: Tempo de conexão expirado. Verifique as configurações do servidor MongoDB.";
    } catch (\MongoDB\Driver\Exception\AuthenticationException $e) {
        echo "Erro de autenticação: As credenciais fornecidas são inválidas. Verifique o nome de usuário e a senha.";
    } catch (\MongoDB\Driver\Exception\BulkWriteException $e) {
        echo "Erro ao inserir documento: " . $e->getMessage();
    } catch (\MongoDB\Driver\Exception\Exception $e) {
        echo "Erro ao conectar ao MongoDB: " . $e->getMessage();
    } catch (\Exception $e) {
        echo "Erro geral: " . $e->getMessage();
    }
} else {
    // Redirecionar para a página do formulário se alguém tentar acessar diretamente
    header('Location: index.html');
}
?>