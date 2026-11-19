<?php

require_once "../config/DBConfig.php";
require_once "../Model/Categoria/Categoria.php";

class CategoriaRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = DBConfig::getConnection();
    }

    public function salvar($nome): void
    {
        try {
            $sql = "INSERT INTO Categorias (nome)
                VALUES (:nome)";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ":nome" => strtoupper($nome)
            ]);

        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function buscarPorId(int $id): ?Categoria
    {
        try {
            $sql = "SELECT * FROM Categorias WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([":id" => $id]);

            $dados = $stmt->fetch();

            if (!$dados) {
                return null;
            }

            return new Categoria(
                (int)$dados["id"],
                $dados["nome"]
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function buscarTodos(): ?array
    {
        try {
            $sql = "SELECT * FROM Categorias";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetchAll();
            if (!$dados) {
                return null;
            }
            return $dados;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function deletePorId(int $id): void
    {
        try {
            $sql = "DELETE FROM Categorias WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function update(int $id, string $nome): void
    {
        $sql = "UPDATE Categorias SET nome = :nome WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['nome' => $nome, 'id' => $id]);

    }
}