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

    public function getAllFilter(
        string $type = "ALL",
        ?DateTime $dataInicio = null,
        ?DateTime $dataFinal = null,
        ?int $categoriaId = 0
    ): ?array {

        $sql = "SELECT f.*
            FROM financas f
            LEFT JOIN creditos c ON c.idFinancia = f.id
            LEFT JOIN debitos d ON d.idFinancia = f.id
            WHERE 1 = 1";

        $params = [];

        if ($type === "CREDITO") {
            $sql .= " AND c.idFinancia IS NOT NULL";
        } elseif ($type === "DEBITO") {
            $sql .= " AND d.idFinancia IS NOT NULL";
        } elseif ($type !== "ALL") {
            throw new InvalidArgumentException("Tipo inválido.");
        }

        if ($dataInicio !== null) {
            $sql .= " AND f.data >= :dataInicio";
            $params["dataInicio"] = $dataInicio->format("Y-m-d");
        }

        if ($dataFinal !== null) {
            $sql .= " AND f.data <= :dataFinal";
            $params["dataFinal"] = $dataFinal->format("Y-m-d");
        }

        if ($categoriaId !== null && $categoriaId > 0) {
            $sql .= " AND f.idCategoria = :categoriaId";
            $params["categoriaId"] = $categoriaId;
        }

        $sql .= " ORDER BY f.data DESC, f.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) return null;

        $resultado = [];

        foreach ($rows as $r) {
            $resultado[] = new Financa(
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

    public function getSaldo(): ?int
    {
        $sql = "SELECT
                totalCreditos,
                totalDebitos,
                totalCreditos - totalDebitos AS saldo
            FROM (
                SELECT
                    COALESCE((
                        SELECT SUM(f.valorEmCentavos)
                        FROM creditos c
                        INNER JOIN financas f ON f.id = c.idFinancia
                    ), 0) AS totalCreditos,

                    COALESCE((
                        SELECT SUM(f.valorEmCentavos)
                        FROM debitos d
                        INNER JOIN financas f ON f.id = d.idFinancia
                    ), 0) AS totalDebitos
            ) AS totais";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $r = $stmt->fetch(PDO::FETCH_ASSOC);

        return $r !== false ? $r["saldo"] : null;
    }
}
