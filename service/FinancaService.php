<?php
require_once "../repository/FinancaRepository.php";
require_once "../model/Financa/Financa.php";
require_once "../model/Financa/FinancaDTO.php";

class FinancaService
{
    private FinancaRepository $financasRepository;

    public function __construct()
    {
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

    public function getAll(string $type = "ALL", ?DateTime $dataInicio = null, ?DateTime $dataFinal = null, ?int $categoriaId = 0): ?array
    {
        return $this->financasRepository->getAllFilter($type, $dataInicio,$dataFinal,$categoriaId);
    }

    public function updateFinanca(int $id, FinancaDTO $DTO): void
    {
        $this->financasRepository->update($id, $DTO);
    }

    public function deleteFinanca(int $id): void
    {
        $this->financasRepository->delete($id);
    }

    public function getSaldo(): ?string
    {
        return number_format($this->financasRepository->getSaldo() / 100, 2, ",", ".");
    }
}
