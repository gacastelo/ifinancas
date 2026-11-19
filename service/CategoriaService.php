<?php
require_once "../repository/CategoriaRepository.php";
require_once "../model/Categoria/Categoria.php";

class CategoriaService
{
    private CategoriaRepository $categoriasRepository;

    public function __construct()
    {
        $this->categoriasRepository = new CategoriaRepository();
    }

    public function saveCategoria(string $nomeCategoria): void
    {
        $this->categoriasRepository->salvar($nomeCategoria);
    }

    public function getCategoria(int $id): ?Categoria
    {
        return $this->categoriasRepository->buscarPorId($id);
    }

    public function getAll(): ?array
    {
        return $this->categoriasRepository->buscarTodos();
    }

    public function updateCategoria(int $id, string $nomeCategoria): void
    {
        $this->categoriasRepository->update($id, $nomeCategoria);
    }

    public function deleteCategoria(int $id): void
    {
        $this->categoriasRepository->deletePorId($id);
    }
}
