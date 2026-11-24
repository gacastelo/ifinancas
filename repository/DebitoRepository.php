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
        try {
            $sql = "INSERT INTO financas
                    (data, descricao, valorEmCentavos, idCategoria, idUsuario)
                    VALUES
                    (:data, :descricao, :valorEmCentavos, :idCategoria, :idUsuario)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($this->params($DTO));

            $idFinancia = (int)$this->conn->lastInsertId();

            $sql = "INSERT INTO debitos (idFinancia, requerimentoID)
                    VALUES (:idFinancia, :requerimentoID)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ":idFinancia" => $idFinancia,
                ":requerimentoID" => $DTO->getRequerimentoID()
            ]);


            $debito = $this->getById($idFinancia);

            if ($debito === null) {
                throw new RuntimeException("Não foi possível recuperar o débito criado.");
            }

            return $debito;

        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function getById(int $id): ?Debito
    {
        $sql = "SELECT f.*, d.requerimentoID
                FROM financas f
                INNER JOIN debitos d ON d.idFinancia = f.id
                WHERE f.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);

        $r = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$r) {
            return null;
        }

        return new Debito(
            (int)$r["id"],
            new DateTime($r["data"]),
            $r["descricao"],
            (int)$r["valorEmCentavos"],
            (int)$r["idCategoria"],
            (int)$r["idUsuario"],
            (string)$r["requerimentoID"]
        );
    }

    public function getAll(): ?array
    {
        $sql = "SELECT f.*, d.requerimentoID
                FROM financas f
                INNER JOIN debitos d ON d.idFinancia = f.id
                ORDER BY f.data DESC, f.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        $resultado = [];

        foreach ($rows as $r) {
            $resultado[] = new Debito(
                (int)$r["id"],
                new DateTime($r["data"]),
                $r["descricao"],
                (int)$r["valorEmCentavos"],
                (int)$r["idCategoria"],
                (int)$r["idUsuario"],
                (string)$r["requerimentoID"]
            );
        }

        return $resultado;
    }

    public function update(int $id, DebitoDTO $DTO): ?Debito
    {
        if ($this->getById($id) === null) {
            return null;
        }

        try {

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

            $sql = "UPDATE debitos
                    SET requerimentoID = :requerimentoID
                    WHERE idFinancia = :idFinancia";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ":requerimentoID" => $DTO->getRequerimentoID(),
                ":idFinancia" => $id
            ]);

            return $this->getById($id);

        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function delete(int $id): void
    {
        $sql = "DELETE f
                FROM financas f
                INNER JOIN debitos d ON d.idFinancia = f.id
                WHERE f.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" => $id]);
    }

    private function params(DebitoDTO $DTO): array
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
