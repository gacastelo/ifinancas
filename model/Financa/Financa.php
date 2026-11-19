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
}