<?php

class DBConfig
{
    public static string $servername = "localhost";
    public static string $username = "root";
    public static string $password = "";

    public static function getConnection(): PDO
    {
        try {
            return new PDO(
                "mysql:host=" . DBConfig::$servername . ";dbname=ifinancas;charset=utf8mb4",
                DBConfig::$username,
                DBConfig::$password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }
    private static function initializeCategories(): void{
        try {
            $conn = self::getConnection();
            $sql = "CREATE TABLE `ifinancas`.`categorias` (
                    `id` INT NOT NULL AUTO_INCREMENT , 
                    `nome` VARCHAR(50) NOT NULL UNIQUE, 
                    PRIMARY KEY (`id`))";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $conn = null;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    private static function initializeFinanca(): void
    {
        try {
            $conn = self::getConnection();
            $sql = "CREATE TABLE `ifinancas`.`financas` (
                    `id`  NOT NULL, 
                    `nome` VARCHAR(50) NOT NULL UNIQUE, 
                    PRIMARY KEY (`id`))";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $conn = null;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function initializeDB(): void
    {
        self::initializeCategories();
    }
}