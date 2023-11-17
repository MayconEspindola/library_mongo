<?php

namespace app\config;

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

class Database
{
    public static function getConnection()
    {
        $envpath = realpath(dirname(__FILE__) . '/../env.ini');
        $env = parse_ini_file($envpath);

        $uri = sprintf(
            'mongodb://%s:%s@%s/%s',
            $env['username'],
            $env['password'],
            $env['host'],
            $env['database']
        );

        try {
            $client = new Client($uri);
            return $client->selectDatabase($env['database']);
        } catch (\Exception $e) {
            // Handle connection error
            // die("Erro: " . $e->getMessage());
            return null;
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
        } catch (\Exception $e) {
            // Handle query error
            return null;
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
        } catch (\Exception $e) {
            // Handle insert error
            return false;
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
            $collection->deleteOne($filter);
            return true;
        } catch (\Exception $e) {
            // Handle delete error
            return false;
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
        } catch (\Exception $e) {
            // Handle update error
            return false;
        }
    }
}
?>