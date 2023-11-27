<?php

namespace app\config;

use MongoDB\Client;
use MongoDB\Driver\Exception\Exception as MongoDBException;
use MongoDB\BSON\Regex;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once 'EnvironmentSettings.php';

class Database
{
    public static function getConnection()
    {
        try {
            $envSettings = new EnvironmentSettings();
            $env = $envSettings->obterConfiguracoes();

            $uri = sprintf(
                'mongodb://%s:%s@%s:%s',
                $env['DATABASE']['username'],
                $env['DATABASE']['password'],
                $env['DATABASE']['host'],
                $env['DATABASE']['porta']
            );

            $client = new Client($uri);
            return $client->selectDatabase($env['DATABASE']['database']);
        } catch (MongoDBException $e) {
            throw new \RuntimeException("Erro ao conectar ao MongoDB: " . $e->getMessage());
        }
    }

    public static function getResultFromQuery($collectionName, $filter = [])
    {
        $database = self::getConnection();

        if ($database === null) {
            return null;
        }

        $collection = $database->selectCollection($collectionName);

        try {
            $result = $collection->find($filter);
            return $result;
        } catch (MongoDBException $e) {
            throw new \RuntimeException("Erro na consulta: " . $e->getMessage());
        }
    }

    public static function insertDocument($collectionName, $document)
    {
        $database = self::getConnection();

        if ($database === null) {
            return false;
        }

        $collection = $database->selectCollection($collectionName);

        try {
            $collection->insertOne($document);
            return true;
        } catch (MongoDBException $e) {
            throw new \RuntimeException("Erro ao inserir documento: " . $e->getMessage());
        }
    }

    public static function deleteDocument($collectionName, $filter)
    {
        $database = self::getConnection();
    
        if ($database === null) {
            return false;
        }
    
        $collection = $database->selectCollection($collectionName);
    
        try {
            $result = $collection->deleteOne($filter);
    
            if ($result->getDeletedCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (MongoDBException $e) {
            throw new \RuntimeException("Erro ao excluir documento: " . $e->getMessage());
        }
    }
    

    public static function updateDocument($collectionName, $filter, $update)
    {
        $database = self::getConnection();

        if ($database === null) {
            return false;
        }

        $collection = $database->selectCollection($collectionName);

        try {
            $collection->updateOne($filter, $update);
            return true;
        } catch (MongoDBException $e) {
            throw new \RuntimeException("Erro ao atualizar documento: " . $e->getMessage());
        }
    }
}
?>