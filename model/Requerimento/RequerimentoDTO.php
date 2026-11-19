<?php
class RequerimentoDTO
{
    protected DateTime $data;
    protected string $descricao;
    protected int $valorEmCentavos;
    protected int $idCategoria;
    protected int $idUsuario;

    public function __construct(DateTime $data, string $descricao, int $valorEmCentavos, int $idCategoria, int $idUsuario)
    {
        $this->data = $data;
        $this->descricao = $descricao;
        $this->valorEmCentavos = $valorEmCentavos;
        $this->idCategoria = $idCategoria;
        $this->idUsuario = $idUsuario;
    }

    public function getData(): DateTime { return $this->data; }
    public function getDescricao(): string { return $this->descricao; }
    public function getValorEmCentavos(): int { return $this->valorEmCentavos; }
    public function getIdCategoria(): int { return $this->idCategoria; }
    public function getIdUsuario(): int { return $this->idUsuario; }
}
