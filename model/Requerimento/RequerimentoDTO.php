<?php
class RequerimentoDTO
{
    protected DateTime $data;
    protected string $descricao;
    protected int $valorEmCentavos;
    protected int $idCategoria;
    protected int $idUsuario;
    protected string $status;
    protected ?int $idUsuarioAprovado;
    public function __construct(DateTime $data, string $descricao, int $valorEmCentavos, int $idCategoria, int $idUsuario, string $status = 'EM_ESPERA', ?int $idUsuarioAprovado = null)
    {
        $this->data = $data;
        $this->descricao = $descricao;
        $this->valorEmCentavos = $valorEmCentavos;
        $this->idCategoria = $idCategoria;
        $this->idUsuario = $idUsuario;
        $this->status = $status;
        $this->idUsuarioAprovado = $idUsuarioAprovado;
    }

    public function getData(): DateTime { return $this->data; }
    public function getDescricao(): string { return $this->descricao; }
    public function getValorEmCentavos(): int { return $this->valorEmCentavos; }
    public function getIdCategoria(): int { return $this->idCategoria; }
    public function getIdUsuario(): int { return $this->idUsuario; }
    public function getStatus(): string { return $this->status; }
    public function getIdUsuarioAprovado(): ?int { return $this->idUsuarioAprovado; }
}
