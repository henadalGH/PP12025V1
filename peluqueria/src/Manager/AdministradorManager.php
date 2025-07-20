<?php

namespace App\Manager;

use App\Repository\PeluqueroRepository;
use App\Repository\ClienteRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuario;
use App\Entity\Peluquero;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdministradorManager
{
    private PeluqueroRepository $pRepository;
    private ClienteRepository $cRepository;
    private UsuarioRepository $uRepository;
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $passwordHasher;
    
    public function __construct(
        PeluqueroRepository $pRepository,
        UserPasswordHasherInterface $passwordHasher,
        UsuarioRepository $uRepository,
        EntityManagerInterface $em,
        clienteRepository $cRepository
    ) {
        $this->pRepository = $pRepository;
        $this->uRepository = $uRepository;
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
        $this->cRepository= $cRepository;
    }

    public function obtenerPeluqueros()
    {
        return $this->pRepository->findAll();
    }

    public function obtenerClientes()
    {
        return $this->cRepository->findAll();
    }

    public function registrarPeluquero(array $nPeluquero)
    {
        $nUsuario = new Usuario();
        $nUsuario->setNombre($nPeluquero['nombre']);
        $nUsuario->setApellido($nPeluquero['apellido']);
        $nUsuario->setEmail($nPeluquero['email']);

        
        $hashedPassword = $this->passwordHasher->hashPassword($nUsuario, $nPeluquero['password']);
        $nUsuario->setPassword($hashedPassword);

        $nUsuario->setRoles(["ROLE_PELUQUERO"]);

        $peluquero = new Peluquero();
        $peluquero->setUsuario($nUsuario);

        $this->em->persist($nUsuario);   
        $this->em->persist($peluquero); 
        $this->em->flush();
    }

    public function eleminarPeluquero(int $id)
    {
        $usuario = $this->uRepository->find($id);

    if (!$usuario) {
        throw new \Exception("Usuario no encontrado.");
    }
    $this->em->remove($usuario);
    $this->em->flush();
    }
}
