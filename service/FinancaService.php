<?php
require_once "../repository/FinancaRepository.php";
class FinancaService
{
    private FinancaRepository $financasRepository;
    public function __construct(){
        $this->financasRepository = new FinancaRepository();
    }

    public function saveFinanca(FinancaDTO $DTO): void
    {
        $this->financasRepository->save($DTO);
    }

    public function getFinanca(int $id): ?Financa
    {
        return $this->financasRepository->getById($id);
    }

    public function getAll(): ?array
    {
        return $this->financasRepository->getAll();
    }

    public function updateFinanca(int $id, FinancaDTO $DTO): void
    {
        $this->financasRepository->update($id, $DTO);
    }

    public function deleteFinanca(int $id): void
    {
        $this->financasRepository->delete($id);
    }
}