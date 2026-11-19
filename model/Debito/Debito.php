<?php

class Debito extends Financa
{
    private string $requerimentoID;

    public function __construct(int $id, DateTime $data, string $descricao, int $valorEmCentavos, int $idCategoria, int $idUsuario, string $requerimentoID)
    {
        parent::__construct($id, $data, $descricao, $valorEmCentavos, $idCategoria, $idUsuario);
        $this->requerimentoID = $requerimentoID;
    }
}