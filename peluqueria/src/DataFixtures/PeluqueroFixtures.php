<?php

namespace App\DataFixtures;

use App\Entity\Peluquero;
use App\Repository\UsuarioRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PeluqueroFixtures extends Fixture
{
    private UsuarioRepository $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function load(ObjectManager $manager): void
    {
        // Obtener todos los usuarios que ya existen en la base
        $usuarios = $this->usuarioRepository->findAll();

        foreach ($usuarios as $usuario) {
            if (\in_array('ROLE_PELUQUERO', $usuario->getRoles())) {

                // Evitar duplicados si ya tiene Peluquero asignado
                if ($usuario->getPeluquero() === null) {
                    $peluquero = new Peluquero();
                    $peluquero->setUsuario($usuario);

                    $manager->persist($peluquero);
                }
            }
        }

        $manager->flush();
    }
}
