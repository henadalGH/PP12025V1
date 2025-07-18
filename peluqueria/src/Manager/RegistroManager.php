<?php
namespace App\Manager;

use App\Entity\Usuario;
use App\Entity\Cliente;
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

        // Verifica si ya existe un usuario con ese email
        $usuarioExistente = $this->em->getRepository(Usuario::class)
            ->findOneBy(['email' => $usuario['email']]);

        if ($usuarioExistente) {
            throw new \Exception("Ya existe un usuario registrado con ese email.");
        }

        // Crear nuevo Usuario
        $nusuario = new Usuario();
        $nusuario->setNombre($usuario['nombre']);
        $nusuario->setApellido($usuario['apellido']);
        $nusuario->setEmail($usuario['email']);
        $hashedPassword = $this->passwordHasher->hashPassword($nusuario, $usuario['password']);
        $nusuario->setPassword($hashedPassword);
        $nusuario->setRoles([$roles[0]]);
        
        $cliente = new Cliente();
        $cliente->setUsuario($nusuario);
        $contacto = $usuario['contacto'] ?? $usuario['email'];
        $cliente->setContacto($contacto);

        
        $nusuario->setCliente($cliente);

        $this->em->persist($nusuario);
        $this->em->persist($cliente); 
        $this->em->flush();
    }
}
