<?php

class Credito extends Financa
{
    public function __construct(int $id, DateTime $data, string $descricao, int $valorEmCentavos, int $idCategoria, int $idUsuario)
    {
        parent::__construct($id, $data, $descricao, $valorEmCentavos, $idCategoria, $idUsuario);
    }
}