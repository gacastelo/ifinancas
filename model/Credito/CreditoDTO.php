<?php
require "../Model/Financa/FinancaDTO.php";
class CreditoDTO extends FinancaDTO
{
    public function __construct(DateTime $data, string $descricao, int $valorEmCentavos, int $idCategoria, int $idUsuario)
    {
        parent::__construct($data, $descricao, $valorEmCentavos, $idCategoria, $idUsuario);
    }
}