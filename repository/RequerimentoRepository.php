<?php
require_once "../config/DBConfig.php";
require_once "../model/Requerimento/Requerimento.php";
require_once "../model/Requerimento/RequerimentoDTO.php";

class RequerimentoRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = DBConfig::getConnection();
    }

    public function save(RequerimentoDTO $DTO): Requerimento
    {
        $sql = "INSERT INTO Requerimentos
            (data, descricao, valorEmCentavos, idCategoria,
             idUsuario, status, idUsuarioAprovado)
            VALUES
            (:data, :descricao, :valorEmCentavos, :idCategoria,
             :idUsuario, :status, :idUsuarioAprovado)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($this->params($DTO));

        return $this->getById((int) $this->conn->lastInsertId());
    }

    public function getById(int $id): ?Requerimento
    {
        $stmt = $this->conn->prepare("SELECT * FROM Requerimentos WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$r) return null;
        return new Requerimento((int)$r["id"], new DateTime($r["data"]), $r["descricao"],
            (int)$r["valorEmCentavos"],
            (int)$r["idCategoria"],
            (int)$r["idUsuario"],
            $r["status"],
            new DateTime($r["createdAt"]),
            new DateTime($r["updatedAt"]),
            $r["idUsuarioAprovado"] !== null ? (int)$r["idUsuarioAprovado"] : null);
    }

    public function getAll(): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Requerimentos ORDER BY data DESC, id DESC");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$rows) return null;
        $resultado = [];
        foreach ($rows as $r) {
            $resultado[] = new Requerimento(
                (int)$r["id"],
                new DateTime($r["data"]),
                $r["descricao"],
                (int)$r["valorEmCentavos"],
                (int)$r["idCategoria"],
                (int)$r["idUsuario"],
                $r["status"],
                new DateTime($r["createdAt"]),
                new DateTime($r["updatedAt"]),
                $r["idUsuarioAprovado"] !== null ? (int)$r["idUsuarioAprovado"] : null);
        }
        return $resultado;
    }

    public function update(int $id, RequerimentoDTO $DTO): ?Requerimento
    {
        $sql = "UPDATE Requerimentos SET
                data = :data,
                descricao = :descricao,
                valorEmCentavos = :valorEmCentavos,
                idCategoria = :idCategoria,
                idUsuario = :idUsuario,
                status = :status,
                idUsuarioAprovado = :idUsuarioAprovado
            WHERE id = :id";

        $params = $this->params($DTO);
        $params[":id"] = $id;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $this->getById($id);
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("DELETE FROM Requerimentos WHERE id = :id");
        $stmt->execute([":id" => $id]);
    }

    private function params(RequerimentoDTO $DTO): array
    {
        $params = [
            ":data" => $DTO->getData()->format("Y-m-d"),
            ":descricao" => $DTO->getDescricao(),
            ":valorEmCentavos" => $DTO->getValorEmCentavos(),
            ":idCategoria" => $DTO->getIdCategoria(),
            ":idUsuario" => $DTO->getIdUsuario(),
            ":status" => $DTO->getStatus(),
            ":idUsuarioAprovado" => $DTO->getIdUsuarioAprovado()
        ];

        return $params;
    }
}
