<?php

class Requerimento
{
    protected string $id;
    protected DateTime $data;
    protected string $descricao;
    protected int $valorEmCentavos;
    protected int $idCategoria;
    protected int $idUsuario;
    protected DateTime $createdAt;
    protected DateTime $updatedAt;
}