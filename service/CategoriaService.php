<?php
require_once "../repository/CategoriaRepository.php";
class CategoriaService
{
    private $categoriasRepository;

    public function __construct()
    {
        $this->categoriasRepository = new CategoriaRepository();
    }


    public function saveCategoria(string $nomeCategoria): void{
        $this->categoriasRepository->salvar($nomeCategoria);

    }

    public function getAll(): ?array{
      return $this->categoriasRepository->buscarTodos();
    }
}