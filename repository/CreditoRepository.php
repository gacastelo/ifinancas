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
        $sql = "INSERT INTO Creditos (data, descricao, valorEmCentavos, idCategoria, idUsuario)
                VALUES (:data, :descricao, :valorEmCentavos, :idCategoria, :idUsuario)";
        $stmt = $this->conn->prepare($sql);
        $params = $this->params($DTO);
        $stmt->execute($params);
        return $this->getById((int)$this->conn->lastInsertId());
    }

    public function getById(int $id): ?Credito
    {
        $stmt = $this->conn->prepare("SELECT * FROM Creditos WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$r) return null;
        return new Credito((int)$r["id"], new DateTime($r["data"]), $r["descricao"],
            (int)$r["valorEmCentavos"], (int)$r["idCategoria"], (int)$r["idUsuario"]);
    }

    public function getAll(): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Creditos ORDER BY data DESC, id DESC");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$rows) return null;
        $resultado = [];
        foreach ($rows as $r) {
            $resultado[] = new Credito((int)$r["id"], new DateTime($r["data"]), $r["descricao"],
                (int)$r["valorEmCentavos"], (int)$r["idCategoria"], (int)$r["idUsuario"]);
        }
        return $resultado;
    }

    public function update(int $id, CreditoDTO $DTO): ?Credito
    {
        $sql = "UPDATE Creditos SET data = :data, descricao = :descricao,
                valorEmCentavos = :valorEmCentavos, idCategoria = :idCategoria,
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
        $stmt = $this->conn->prepare("DELETE FROM Creditos WHERE id = :id");
        $stmt->execute([":id" => $id]);
    }

    private function params(CreditoDTO $DTO): array
    {
        $params = [
            ":data" => $DTO->getData()->format("Y-m-d"),
            ":descricao" => $DTO->getDescricao(),
            ":valorEmCentavos" => $DTO->getValorEmCentavos(),
            ":idCategoria" => $DTO->getIdCategoria(),
            ":idUsuario" => $DTO->getIdUsuario()
        ];
        
        return $params;
    }
}
