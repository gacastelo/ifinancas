<?php

class UsuarioDTO
{
    private string $nome;
    private string $email;

    protected function __construct(string $nome, string $email)
    {
        $this->nome = $nome;
        $this->email = $email;
    }
}