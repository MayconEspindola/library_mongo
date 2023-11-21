<?php

use app\config\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {
    private $collection;

    public function setUp(): void {
        // Não é necessário configurar manualmente a conexão, pois a classe Database já lida com isso
        $this->collection = 'test'; // Substitua pelo nome da sua coleção
    }

    public function tearDown(): void {
        // Limpar os dados após cada teste
        Database::deleteDocument($this->collection, []);
    }

    public function test_insertDocument() {
        $document = ['name' => 'John Doe', 'age' => 30];
        $result = Database::insertDocument($this->collection, $document);

        $this->assertTrue($result);

        // Verifique se o documento foi realmente inserido no MongoDB
        $insertedDocument = Database::getResultFromQuery($this->collection, ['name' => 'John Doe']);
        $this->assertNotNull($insertedDocument);
    }

    public function test_deleteDocument() {
        // Inserir um documento para ser excluído
        $document = ['name' => 'Jane Doe', 'age' => 25];
        Database::insertDocument($this->collection, $document);

        $filter = ['name' => 'Jane Doe'];
        $result = Database::deleteDocument($this->collection, $filter);

        $this->assertTrue($result);

        // Verifique se o documento foi realmente excluído do MongoDB
        $deletedDocument = Database::getResultFromQuery($this->collection, ['name' => 'Jane Doe']);
        $this->assertEmpty($deletedDocument);
    }
}
?>