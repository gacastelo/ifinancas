<?php

class Financa
{
    protected int $id;
    protected DateTime $data;
    protected string $descricao;
    protected int $valorEmCentavos;
    protected int $idCategoria;
    protected int $idUsuario;
    protected DateTime $createdAt;
    protected DateTime $updatedAt;

    public function __construct(int $id, DateTime $data, string $descricao, int $valorEmCentavos, int $idCategoria, int $idUsuario)
    {
        $this->id = $id;
        $this->data = $data;
        $this->descricao = $descricao;
        $this->valorEmCentavos = $valorEmCentavos;
        $this->idCategoria = $idCategoria;
        $this->idUsuario = $idUsuario;
        $this->createdAt = new DateTime();
        $this->updatedAt = $this->createdAt;
    }

    public function __toString(): string
    {
        return
            "ID:{$this->id}\n" .
            "Data:" . $this->data->format("d/m/Y") . "\n" .
            "Descricao: {$this->descricao}\n" .
            "Valor:" . number_format($this->valorEmCentavos / 100, 2, ",", ".") . "\n" .
            "Categoria: {$this->idCategoria}\n" .
            "Usuario: {$this->idUsuario}\n" .
            "Criado_em: " . $this->createdAt->format("d/m/Y H:i:s") . "\n" .
            "Atualizado_em: " . $this->updatedAt->format("d/m/Y H:i:s");
    }

    public function getData(): DateTime
    {
        return $this->data;
    }
    public function getDescricao(): string
    {
        return $this->descricao;
    }
    public function getValorEmCentavos(): int
    {
        return $this->valorEmCentavos;
    }
    public function getIdCategoria(): int
    {
        return $this->idCategoria;
    }
    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function getValor(): string
    {
        return number_format($this->valorEmCentavos / 100, 2, ",", ".");
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "data" => $this->data->format("Y-m-d"),
            "descricao" => $this->descricao,
            "valorEmCentavos" => $this->valorEmCentavos,
            "idCategoria" => $this->idCategoria,
            "idUsuario" => $this->idUsuario
        ];
    }
}