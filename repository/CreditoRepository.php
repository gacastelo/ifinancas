<?php
require_once "../config/DBConfig.php";
require_once "../model/Credito/Credito.php";
require_once "../model/Credito/CreditoDTO.php";

class CreditoRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = DBConfig::getConnection();
    }

    public function save(CreditoDTO $DTO): Credito
    {
        try {
            $sql = "INSERT INTO financas
                    (data, descricao, valorEmCentavos, idCategoria, idUsuario)
                    VALUES
                    (:data, :descricao, :valorEmCentavos, :idCategoria, :idUsuario)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($this->params($DTO));

            $idFinancia = (int)$this->conn->lastInsertId();

            $sql = "INSERT INTO creditos (idFinancia)
                    VALUES (:idFinancia)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([":idFinancia" => $idFinancia]);

            $credito = $this->getById($idFinancia);

            if ($credito === null) {
                throw new RuntimeException("Não foi possível recuperar o crédito criado.");
            }

            return $credito;

        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function getById(int $id): ?Credito
    {
        $sql = "SELECT f.*
                FROM financas f
                INNER JOIN creditos c ON c.idFinancia = f.id
                WHERE f.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);

        $r = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$r) {
            return null;
        }

        return new Credito(
            (int)$r["id"],
            new DateTime($r["data"]),
            $r["descricao"],
            (int)$r["valorEmCentavos"],
            (int)$r["idCategoria"],
            (int)$r["idUsuario"]
        );
    }

    public function getAll(): ?array
    {
        $sql = "SELECT f.*
                FROM financas f
                INNER JOIN creditos c ON c.idFinancia = f.id
                ORDER BY f.data DESC, f.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        $resultado = [];

        foreach ($rows as $r) {
            $resultado[] = new Credito(
                (int)$r["id"],
                new DateTime($r["data"]),
                $r["descricao"],
                (int)$r["valorEmCentavos"],
                (int)$r["idCategoria"],
                (int)$r["idUsuario"]
            );
        }

        return $resultado;
    }

    public function update(int $id, CreditoDTO $DTO): ?Credito
    {
        if ($this->getById($id) === null) {
            return null;
        }

        $sql = "UPDATE financas
                SET data = :data,
                    descricao = :descricao,
                    valorEmCentavos = :valorEmCentavos,
                    idCategoria = :idCategoria,
                    idUsuario = :idUsuario
                WHERE id = :id";

        $params = $this->params($DTO);
        $params[":id"] = $id;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $this->getById($id);
    }

    public function delete(int $id): void
    {
        $sql = "DELETE f
                FROM financas f
                INNER JOIN creditos c ON c.idFinancia = f.id
                WHERE f.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);
    }

    private function params(CreditoDTO $DTO): array
    {
        return [
            ":data" => $DTO->getData()->format("Y-m-d"),
            ":descricao" => $DTO->getDescricao(),
            ":valorEmCentavos" => $DTO->getValorEmCentavos(),
            ":idCategoria" => $DTO->getIdCategoria(),
            ":idUsuario" => $DTO->getIdUsuario()
        ];
    }
}
