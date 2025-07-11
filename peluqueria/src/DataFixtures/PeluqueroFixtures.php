<?php
namespace App\DataFixtures;

use App\Entity\Peluquero;
use App\Repository\UsuarioRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PeluqueroFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UsuarioRepository $usuarioRepository) {}

    public function load(ObjectManager $manager): void
    {
        // Correos de usuarios con rol ROLE_PELUQUERO
        $emails = [
            'mariaantoniasis@gmail.com',
            'andreronchi@gmail.com',
            'lauravareta@gmail.com',
        ];

        foreach ($emails as $email) {
            $usuario = $this->usuarioRepository->findOneBy(['email' => $email]);

            if ($usuario && $usuario->getPeluquero() === null) {
                $peluquero = new Peluquero();
                $peluquero->setUsuario($usuario); // solo relacionamos, sin nombre

                $manager->persist($peluquero);
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
