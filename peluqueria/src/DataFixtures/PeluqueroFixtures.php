<?php

namespace App\DataFixtures;

use App\Entity\Peluquero;
use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PeluqueroFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Solo los usuarios con rol ROLE_PELUQUERO (índices 1, 2, 3)
        for ($i = 1; $i <= 3; $i++) {
            /** @var Usuario $usuario */
            $usuario = $this->getReference('usuario_' . $i);

            // Si el peluquero no existe todavía
            if ($usuario->getPeluquero() === null) {
                $peluquero = new Peluquero();
                $peluquero->setUsuario($usuario);

                $manager->persist($peluquero);

                $this->addReference('peluquero_' . ($i - 1), $peluquero);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UsuarioFixtures::class,
        ];
    }
}
