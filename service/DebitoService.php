<?php
require_once "../repository/DebitoRepository.php";
require_once "../model/Debito/Debito.php";
require_once "../model/Debito/DebitoDTO.php";

class DebitoService
{
    private DebitoRepository $debitosRepository;

    public function __construct()
    {
        $this->debitosRepository = new DebitoRepository();
    }

    public function saveDebito(DebitoDTO $DTO): void
    {
        $this->debitosRepository->save($DTO);
    }

    public function getDebito(int $id): ?Debito
    {
        return $this->debitosRepository->getById($id);
    }

    public function getAll(): ?array
    {
        return $this->debitosRepository->getAll();
    }

    public function updateDebito(int $id, DebitoDTO $DTO): void
    {
        $this->debitosRepository->update($id, $DTO);
    }

    public function deleteDebito(int $id): void
    {
        $this->debitosRepository->delete($id);
    }
}
