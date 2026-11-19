<?php
require_once "../repository/RequerimentoRepository.php";
require_once "../model/Requerimento/Requerimento.php";
require_once "../model/Requerimento/RequerimentoDTO.php";

class RequerimentoService
{
    private RequerimentoRepository $requerimentosRepository;

    public function __construct()
    {
        $this->requerimentosRepository = new RequerimentoRepository();
    }

    public function saveRequerimento(RequerimentoDTO $DTO): void
    {
        $this->requerimentosRepository->save($DTO);
    }

    public function getRequerimento(int $id): ?Requerimento
    {
        return $this->requerimentosRepository->getById($id);
    }

    public function getAll(): ?array
    {
        return $this->requerimentosRepository->getAll();
    }

    public function updateRequerimento(int $id, RequerimentoDTO $DTO): void
    {
        $this->requerimentosRepository->update($id, $DTO);
    }

    public function deleteRequerimento(int $id): void
    {
        $this->requerimentosRepository->delete($id);
    }
}
