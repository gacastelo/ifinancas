<?php

require_once "../config/DBConfig.php";
require_once "../model/Usuario/Usuario.php";
require_once "../model/Usuario/UsuarioDTO.php";

class UserRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = DBConfig::getConnection();
    }

    public function save(UsuarioDTO $DTO, string $senhaHash): Usuario
    {
        $sql = "INSERT INTO usuarios
                (nome, email, senha)
                VALUES
                (:nome, :email, :senha)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":nome" => $DTO->getNome(),
            ":email" => $DTO->getEmail(),
            ":senha" => $senhaHash
        ]);

        return $this->getById((int)$this->conn->lastInsertId());
    }

    public function getById(int $id): ?Usuario
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);

        $u = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$u) {
            return null;
        }

        return $this->mapearUsuario($u);
    }

    public function getByEmail(string $email): ?Usuario
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":email" => $email]);

        $u = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$u) {
            return null;
        }

        return $this->mapearUsuario($u);
    }

    public function getAll(): ?array
    {
        $sql = "SELECT * FROM usuarios ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        $resultado = [];

        foreach ($rows as $u) {
            $resultado[] = $this->mapearUsuario($u);
        }

        return $resultado;
    }

    public function update(int $id, UsuarioDTO $DTO): ?Usuario
    {
        $sql = "UPDATE usuarios SET
                    nome = :nome,
                    email = :email
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":nome" => $DTO->getNome(),
            ":email" => $DTO->getEmail(),
            ":id" => $id
        ]);

        return $this->getById($id);
    }

    public function atualizarSenha(int $id, string $senhaHash): void
    {
        $sql = "UPDATE usuarios SET
                    senha = :senha
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":senha" => $senhaHash,
            ":id" => $id
        ]);
    }

    public function delete(int $id): void
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);
    }

    private function mapearUsuario(array $u): Usuario
    {
        return new Usuario(
            (int)$u["id"],
            $u["nome"],
            $u["email"],
            $u["senha"],
            new DateTime($u["created_at"]),
            new DateTime($u["updated_at"])
        );
    }
}