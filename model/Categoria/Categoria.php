<?php

class Categoria
{
    private int $id;
    private string $nome;

    public function __construct(string $nome, int $id = null)
    {
        $this->id = $id;
        $this->nome = $nome;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getId(): int
    {
        return $this->id;
    }
}