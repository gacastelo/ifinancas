<?php

class Usuario
{
    private int $id;
    private string $nome;
    private string $email;
    private string $senha;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(int $id, string $nome, string $email, string $senha, DateTime $createdAt = new DateTime(), DateTime $updatedAt = new DateTime())
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}