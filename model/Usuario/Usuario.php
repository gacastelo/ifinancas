<?php

class Usuario
{
    private int $id;
    private string $nome;
    private string $email;
    private string $senha;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private bool $is_admin;

    public function __construct(int $id, string $nome, string $email, string $senha, DateTime $createdAt = new DateTime(), DateTime $updatedAt = new DateTime(), $is_admin = false)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->is_admin = $is_admin;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function __toString(): string
    {
        return
        "ID: {$this->id}\n" .
        "Nome: {$this->nome}\n" .
        "Email: {$this->email}\n";
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

}