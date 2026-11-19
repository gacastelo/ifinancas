<?php
require_once "../config/DBConfig.php";
require_once "../model/Financa/Financa.php";
require_once "../model/Financa/FinancaDTO.php";

class FinancaRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = DBConfig::getConnection();
    }

    public function save(FinancaDTO $DTO): Financa
    {
        $sql = "INSERT INTO Financas (data, descricao, valorEmCentavos, idCategoria, idUsuario)
                VALUES (:data, :descricao, :valorEmCentavos, :idCategoria, :idUsuario)";
        $stmt = $this->conn->prepare($sql);
        $params = $this->params($DTO);
        $stmt->execute($params);
        return $this->getById((int)$this->conn->lastInsertId());
    }

    public function getById(int $id): ?Financa
    {
        $stmt = $this->conn->prepare("SELECT * FROM Financas WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$r) return null;
        return new Financa((int)$r["id"], new DateTime($r["data"]), $r["descricao"],
            (int)$r["valorEmCentavos"], (int)$r["idCategoria"], (int)$r["idUsuario"]);
    }

    public function getAll(): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Financas ORDER BY data DESC, id DESC");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$rows) return null;
        $resultado = [];
        foreach ($rows as $r) {
            $resultado[] = new Financa((int)$r["id"], new DateTime($r["data"]), $r["descricao"],
                (int)$r["valorEmCentavos"], (int)$r["idCategoria"], (int)$r["idUsuario"]);
        }
        return $resultado;
    }

    public function update(int $id, FinancaDTO $DTO): ?Financa
    {
        $sql = "UPDATE Financas SET data = :data, descricao = :descricao,
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
        $stmt = $this->conn->prepare("DELETE FROM Financas WHERE id = :id");
        $stmt->execute([":id" => $id]);
    }

    private function params(FinancaDTO $DTO): array
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
