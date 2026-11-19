<?php
require_once "../config/DBConfig.php";
require_once "../model/Debito/Debito.php";
require_once "../model/Debito/DebitoDTO.php";

class DebitoRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = DBConfig::getConnection();
    }

    public function save(DebitoDTO $DTO): Debito
    {
        $sql = "INSERT INTO Debitos (data, descricao, valorEmCentavos, idCategoria, idUsuario, requerimentoID)
                VALUES (:data, :descricao, :valorEmCentavos, :idCategoria, :idUsuario, :requerimentoID)";
        $stmt = $this->conn->prepare($sql);
        $params = $this->params($DTO);
        $stmt->execute($params);
        return $this->getById((int)$this->conn->lastInsertId());
    }

    public function getById(int $id): ?Debito
    {
        $stmt = $this->conn->prepare("SELECT * FROM Debitos WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$r) return null;
        return new Debito((int)$r["id"], new DateTime($r["data"]), $r["descricao"],
            (int)$r["valorEmCentavos"], (int)$r["idCategoria"], (int)$r["idUsuario"], (string)$r["requerimentoID"]);
    }

    public function getAll(): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Debitos ORDER BY data DESC, id DESC");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$rows) return null;
        $resultado = [];
        foreach ($rows as $r) {
            $resultado[] = new Debito((int)$r["id"], new DateTime($r["data"]), $r["descricao"],
                (int)$r["valorEmCentavos"], (int)$r["idCategoria"], (int)$r["idUsuario"], (string)$r["requerimentoID"]);
        }
        return $resultado;
    }

    public function update(int $id, DebitoDTO $DTO): ?Debito
    {
        $sql = "UPDATE Debitos SET data = :data, descricao = :descricao,
                valorEmCentavos = :valorEmCentavos, idCategoria = :idCategoria,
                idUsuario = :idUsuario, requerimentoID = :requerimentoID
                WHERE id = :id";
        $params = $this->params($DTO);
        $params[":id"] = $id;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $this->getById($id);
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("DELETE FROM Debitos WHERE id = :id");
        $stmt->execute([":id" => $id]);
    }

    private function params(DebitoDTO $DTO): array
    {
        $params = [
            ":data" => $DTO->getData()->format("Y-m-d"),
            ":descricao" => $DTO->getDescricao(),
            ":valorEmCentavos" => $DTO->getValorEmCentavos(),
            ":idCategoria" => $DTO->getIdCategoria(),
            ":idUsuario" => $DTO->getIdUsuario()
        ];
        $params[":requerimentoID"] = $DTO->getRequerimentoID();
        return $params;
    }
}
