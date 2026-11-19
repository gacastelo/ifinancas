<?php
require_once "../repository/CreditoRepository.php";
require_once "../model/Credito/Credito.php";
require_once "../model/Credito/CreditoDTO.php";

class CreditoService
{
    private CreditoRepository $creditosRepository;

    public function __construct()
    {
        $this->creditosRepository = new CreditoRepository();
    }

    public function saveCredito(CreditoDTO $DTO): void
    {
        $this->creditosRepository->save($DTO);
    }

    public function getCredito(int $id): ?Credito
    {
        return $this->creditosRepository->getById($id);
    }

    public function getAll(): ?array
    {
        return $this->creditosRepository->getAll();
    }

    public function updateCredito(int $id, CreditoDTO $DTO): void
    {
        $this->creditosRepository->update($id, $DTO);
    }

    public function deleteCredito(int $id): void
    {
        $this->creditosRepository->delete($id);
    }
}
