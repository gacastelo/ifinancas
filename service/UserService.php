<?php

require_once "../repository/UserRepository.php";
require_once "../model/Usuario/Usuario.php";
require_once "../model/Usuario/UsuarioDTO.php";

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function saveUsuario(
        UsuarioDTO $DTO,
        string $senha
    ): Usuario {
        if (strlen($senha) < 8) {
            throw new Exception("A senha deve ter pelo menos 8 caracteres.");
        }
        if ($this->userRepository->getByEmail($DTO->getEmail()) !== null) {
            throw new Exception("Este email já está cadastrado.");
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        return $this->userRepository->save($DTO, $senhaHash);
    }

    public function getUsuario(int $id): ?Usuario
    {
        return $this->userRepository->getById($id);
    }

    public function getUsuarioPorEmail(string $email): ?Usuario
    {
        return $this->userRepository->getByEmail($email);
    }

    public function getAll(): ?array
    {
        return $this->userRepository->getAll();
    }
    public function updateUsuario(int $id, UsuarioDTO $DTO): ?Usuario
    {
        if ($this->userRepository->getById($id) === null) {
            throw new Exception("Usuário não encontrado.");
        }

        $usuarioEmail = $this->userRepository->getByEmail($DTO->getEmail());

        if ($usuarioEmail !== null && $usuarioEmail->getId() !== $id) {
            throw new Exception("Este email já está sendo utilizado.");
        }

        return $this->userRepository->update($id, $DTO);
    }
    public function atualizarSenha(int $id, string $senha): void
    {
        if ($this->userRepository->getById($id) === null) {
            throw new Exception("Usuário não encontrado.");
        }

        if (strlen($senha) < 8) {
            throw new Exception("A senha deve ter pelo menos 8 caracteres.");
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $this->userRepository->atualizarSenha($id, $senhaHash);
    }
    public function deleteUsuario(int $id): void
    {
        if ($this->userRepository->getById($id) === null) {
            throw new Exception("Usuário não encontrado.");
        }

        $this->userRepository->delete($id);
    }
    public function verificarSenha(string $email, string $senha): ?Usuario
    {
        $usuario = $this->userRepository->getByEmail($email);

        if ($usuario === null) {
            return null;
        }

        if (!password_verify($senha, $usuario->getSenha())) {
            return null;
        }

        return $usuario;
    }
}