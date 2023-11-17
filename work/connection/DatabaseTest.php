<?php

use app\config\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {
    function test_if_thesre_is_a_connection(){
        $conn = Database::getConnection();
        $this->assertNotNull($conn);
    }

    function test_if_thesre_is_a_result_not_null(){
        $sql = "SELECT * FROM users";
        $result = Database::getResultFromQuerry($sql);
        $this->assertNotNull($result);
    }
}
