<?php
class DebitoDTO extends FinancaDTO
{
    private string $requerimentoID;

    public function __construct(DateTime $data, string $descricao, int $valorEmCentavos, int $idCategoria, int $idUsuario, string $requerimentoID)
    {
        parent::__construct($data, $descricao, $valorEmCentavos, $idCategoria, $idUsuario);
        $this->requerimentoID = $requerimentoID;
    }

    public function getRequerimentoID(): string
    {
        return $this->requerimentoID;
    }
}
