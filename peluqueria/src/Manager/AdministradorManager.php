<?php

namespace App\Manager;

use App\Repository\PeluqueroRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuario;
use App\Entity\Peluquero;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdministradorManager
{
    private PeluqueroRepository $pRepository;

    public function __construct(
        PeluqueroRepository $pRepository,
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        $this->pRepository = $pRepository;
    }

    public function obtenerPeluqueros()
    {
        return $this->pRepository->findAll();
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
}
