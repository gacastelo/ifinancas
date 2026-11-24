<?php
require_once "../repository/RequerimentoRepository.php";
require_once "../model/Requerimento/Requerimento.php";
require_once "../model/Requerimento/RequerimentoDTO.php";
require_once "../model/Debito/DebitoDTO.php";
require_once "../service/DebitoService.php";

class RequerimentoService
{
    private RequerimentoRepository $requerimentosRepository;
    private DebitoService $debitoService;

    public function __construct()
    {
        $this->requerimentosRepository = new RequerimentoRepository();
        $this->debitoService = new DebitoService();
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

    public function aprovarRequerimento(int $id, int $AdminId): void
    {
        $r = $this->requerimentosRepository->getById($id);
        $dto = new DebitoDTO($r->getData(), $r->getDescricao(), $r->getValorEmCentavos(), $r->getIdCategoria(), $r->getIdUsuario(), $id);
        $this->debitoService->saveDebito($dto);
        $this->requerimentosRepository->aprovar($id, $AdminId);
    }

}
