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
            $sql = "CREATE TABLE financas (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    data DATE NOT NULL,
                    descricao VARCHAR(255) NOT NULL,
                    valorEmCentavos INT NOT NULL,
                
                    idCategoria INT NOT NULL,
                    idUsuario INT NOT NULL,
                
                    createdAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    updatedAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                        ON UPDATE CURRENT_TIMESTAMP,
                
                    CONSTRAINT fk_financas_categoria
                        FOREIGN KEY (idCategoria)
                        REFERENCES categorias(id),
                
                    CONSTRAINT fk_financas_usuario
                        FOREIGN KEY (idUsuario)
                        REFERENCES usuarios(id));";
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