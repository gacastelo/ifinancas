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


    private static function initializeCategories(): void
    {
        try {
            $conn = self::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS categorias (
            id INT NOT NULL AUTO_INCREMENT,
            nome VARCHAR(50) NOT NULL UNIQUE,
            PRIMARY KEY (id)
        )";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $conn = null;
        } catch (PDOException $e) {
            echo "Erro ao criar categorias: " . $e->getMessage();
        }
    }

    private static function initializeUsuarios(): void
    {
        try {
            $conn = self::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            senha VARCHAR(255) NOT NULL,
            is_admin TINYINT(1) NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP
        )";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $conn = null;
        } catch (PDOException $e) {
            echo "Erro ao criar usuarios: " . $e->getMessage();
        }
    }

    private static function initializeFinanca(): void
    {
        try {
            $conn = self::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS financas (
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
                REFERENCES usuarios(id)
        )";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $conn = null;
        } catch (PDOException $e) {
            echo "Erro ao criar financas: " . $e->getMessage();
        }
    }

    private static function initializeRequerimento(): void
    {
        try {
            $conn = self::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS requerimentos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            data DATE NOT NULL,
            descricao VARCHAR(255) NOT NULL,
            valorEmCentavos INT NOT NULL,

            idCategoria INT NOT NULL,
            idUsuario INT NOT NULL,
    
            status VARCHAR(30) NOT NULL DEFAULT 'EM_ESPERA',
            idUsuarioAprovado INT,

            createdAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updatedAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP,

            CONSTRAINT fk_requerimentos_categoria
                FOREIGN KEY (idCategoria)
                REFERENCES categorias(id),

            CONSTRAINT fk_requerimentos_usuario
                FOREIGN KEY (idUsuario)
                REFERENCES usuarios(id),
            
            CONSTRAINT fk_requerimentos_idUsuarioAprovado
                FOREIGN KEY (idUsuarioAprovado)
                REFERENCES usuarios(id)
        )";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $conn = null;
        } catch (PDOException $e) {
            echo "Erro ao criar requerimentos: " . $e->getMessage();
        }
    }

    private static function initializeCredito(): void
    {
        try {
            $conn = self::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS creditos (
            idFinancia INT PRIMARY KEY,

            CONSTRAINT fk_creditos_financas
                FOREIGN KEY (idFinancia)
                REFERENCES financas(id)
                ON DELETE CASCADE
        )";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $conn = null;
        } catch (PDOException $e) {
            echo "Erro ao criar creditos: " . $e->getMessage();
        }
    }

    private static function initializeDebito(): void
    {
        try {
            $conn = self::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS debitos (
            idFinancia INT PRIMARY KEY,
            requerimentoID INT NOT NULL,

            CONSTRAINT fk_debitos_financas
                FOREIGN KEY (idFinancia)
                REFERENCES financas(id)
                ON DELETE CASCADE,

            CONSTRAINT fk_debitos_requerimentos
                FOREIGN KEY (requerimentoID)
                REFERENCES requerimentos(id)
        )";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $conn = null;
        } catch (PDOException $e) {
            echo "Erro ao criar debitos: " . $e->getMessage();
        }
    }


    public static function initializeDB(): void
    {
        self::initializeCategories();
        self::initializeUsuarios();
        self::initializeFinanca();
        self::initializeRequerimento();
        self::initializeCredito();
        self::initializeDebito();
    }
}

DBConfig::initializeDB();