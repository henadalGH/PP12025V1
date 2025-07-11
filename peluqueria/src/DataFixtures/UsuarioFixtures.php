<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsuarioFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nombre=[
            "Juan",
            "Maria",
            "Andres",
            "Laura"
        ];

        $apellido=[
            "Perez",
            "Antoniasis",
            "Ronchi",
            "Vareta"
        ];

        $roles=[
            "ROLE_ADMIN",
            "ROLE_PELUQUERO",
            "ROLE_PELUQUERO",
            "ROLE_PELUQUERO"
        ];

        $email=[
            "juanperez@gmail.com",
            "mariaantoniasis@gmail.com",
            "andreronchi@gmail.com",
            "lauravareta@gmail.com"
        ];


    for($i=0;$i<4;$i++)
    {
        $usuario = new Usuario();
        $usuario->setNombre($nombre[$i]);
        $usuario->setApellido($apellido[$i]);
        $usuario->setEmail($email[$i]);
        $usuario->setPassword('$2y$13$8DzG40ClcX2oDtiheEHsWuArRAWR1wMh7e15Sx5kzual4iFvulQaC');
        $usuario->setRoles([$roles[$i]]);
        $manager->persist($usuario);
    }
        $manager->flush();
    }
    }

