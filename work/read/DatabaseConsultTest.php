<?php

use app\config\Database;
use PHPUnit\Framework\TestCase;

class DatabaseConsultTest extends TestCase {
    public function testSelectQuery()
    {
        $sql = "SELECT * FROM users WHERE username = 'john_doe'";
        $result = Database::getResultFromQuery($sql);
        $this->assertNotNull($result);
        // Add additional assertions for the specific expected result
        // Example: $this->assertEquals(1, $result->count());
    }

    public function testCountQuery()
    {
        $sql = "SELECT COUNT(*) as count FROM users";
        $result = Database::getResultFromQuery($sql);
        $this->assertNotNull($result);
        // Add additional assertions for the specific expected count
        // Example: $this->assertEquals(5, $result->toArray()[0]['count']);
    }
}
