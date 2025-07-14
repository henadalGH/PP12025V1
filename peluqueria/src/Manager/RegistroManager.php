<?php

namespace App\Manager;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistroManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function nuevoUsuario(array $usuario): void
    {
        $roles = ["ROLE_CLIENTE"];

        $usuarioExistente = $this->em->getRepository(Usuario::class)
            ->findOneBy(['email' => $usuario['email']]);

        if ($usuarioExistente) {
            throw new \Exception("Ya existe un usuario registrado con ese email."); 
        }

        $nusuario = new Usuario();
        $nusuario->setNombre($usuario['nombre']);
        $nusuario->setApellido($usuario['apellido']);
        $nusuario->setEmail($usuario['email']);
        $nusuario->setRoles([$roles[0]]);

        $hashedPassword = $this->passwordHasher->hashPassword($nusuario, $usuario['password']);
        $nusuario->setPassword($hashedPassword);

        $this->em->persist($nusuario);
        $this->em->flush();
    }
}
