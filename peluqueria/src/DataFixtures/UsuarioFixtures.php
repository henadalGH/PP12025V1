<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\UsuarioRepository;

class UsuarioFixtures extends Fixture
{
    private UsuarioRepository $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $nombres = ["Juan", "Maria", "Andres", "Laura"];
        $apellidos = ["Perez", "Antoniasis", "Ronchi", "Vareta"];
        $emails = ["juanperez@gmail.com", "mariaantoniasis@gmail.com", "andreronchi@gmail.com", "lauravareta@gmail.com"];
        $roles = ["ROLE_ADMIN", "ROLE_PELUQUERO", "ROLE_PELUQUERO", "ROLE_PELUQUERO"];

        for ($i = 0; $i < 4; $i++) {
            $email = $emails[$i];
            $usuarioExistente = $this->usuarioRepository->findOneBy(['email' => $email]);

            if (!$usuarioExistente) {
                $usuario = new Usuario();
                $usuario->setNombre($nombres[$i]);
                $usuario->setApellido($apellidos[$i]);
                $usuario->setEmail($email);
                $usuario->setRoles([$roles[$i]]);
                $usuario->setPassword('$2y$13$8DzG40ClcX2oDtiheEHsWuArRAWR1wMh7e15Sx5kzual4iFvulQaC'); // contraseña fija

                $manager->persist($usuario);
                $this->addReference('usuario_' . $i, $usuario);
            } else {
                // Guardamos la referencia aunque ya exista
                $this->addReference('usuario_' . $i, $usuarioExistente);
            }
        }

        $manager->flush();
    }
}
